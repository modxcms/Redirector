<?php

class RedirectorImportCSVProcessor extends modProcessor {

    private $loadedContexts = array();

    public function getLanguageTopics() {
        return array('redirector:default');
    }

    public function process() {

        $csvFile = $this->getProperty('csv_data_file');
        $csvData = $this->getProperty('csv_data_raw');
        $allData = array();

        // raw data csv
        if(!empty($csvData)) {
            $data = str_getcsv($csvData, "\n");
            foreach($data as $line) {
                $line = str_getcsv($line, ';', '');
                $allData[] = $line;
            }
        }

        // file data csv
        if(!empty($csvFile) && $csvFile['size'] > 0) {
            $fh = fopen($csvFile['tmp_name'], "r");
            while (($line = fgetcsv($fh, 1000, ";")) !== FALSE) {
                $allData[] = $line;
            }
        }

        $total = count($allData);
        $succeed = $failed = 0;
        foreach($allData as $line) {

            // figure out context
            $context = ((isset($line[2]) && !empty($line[2])) ? $line[2] : '');

            // validate pattern
            $valid = $this->validate('pattern', $line[0], $context);
            if(!$valid) {
                $failed++;
                $this->modx->log(modX::LOG_LEVEL_ERROR, '[REDIRECTOR] Pattern URI already exists for "'.$line[0].'"');
                continue;
            }

            // validate target
            $valid = $this->validate('target', $line[1], $context);
            if(!$valid) {
                $failed++;
                $this->modx->log(modX::LOG_LEVEL_ERROR, '[REDIRECTOR] Target URI not-exists for "'.$line[0].'"');
                continue;
            }

            // create entry
            $saved = $this->createRedirect($line);
            if(!$saved) {
                $failed++;
                $this->modx->log(modX::LOG_LEVEL_ERROR, '[REDIRECTOR] Failed to import redirect: "'.$line[0].'" > "'.$line[1].'"');
                continue;
            }

            $succeed++;
        }

        if(empty($total)) {
            return $this->failure($this->modx->lexicon('redirector.import.failed'));
        }
        return $this->success($this->modx->lexicon('redirector.import.success', array(
            'total' => $total,
            'succeed' => $succeed,
            'failed' => $failed,
        )));
    }

    private function createRedirect($data=array()) {

        // when necessary info is empty
        if((isset($data[0]) && empty($data[0])) || (isset($data[1]) && empty($data[1]))) {
            return false;
        }

        /** @var modRedirect $redirect */
        $redirect = $this->modx->newObject('modRedirect');
        $redirect->fromArray(array(
            'pattern' => ltrim($data[0], '/'),
            'target' => ltrim($data[1], '/'),
        ));

        // figure out context key
        if(isset($data[2]) && !empty($data[2])) {

            $contextKey = null;
            if(in_array($data[2], $this->loadedContexts)) {
                $contextKey = $data[2];
            } else {
                $context = $this->modx->getObject('modContext', array('key' => strtolower($data[2])));
                if(!empty($context) && is_object($context)) {
                    $this->loadedContexts[] = $contextKey = $context->get('key');
                }
            }

            $redirect->set('context_key', $contextKey);
        }

        return $redirect->save();
    }

    private function validate($type='pattern', $uri, $context='') {

        switch($type) {
            case 'target':
                $target = $this->getProperty('target');
                $this->modx->getParser();
                $this->modx->parser->processElementTags('', $target, true, true);

                $criteria = array('uri' => $uri);
                if(!empty($context)) { $criteria['context_key'] = $context; }
                $resource = $this->modx->getObject('modResource', $criteria);
                if(empty($resource) || !is_object($resource)) {
                    return false;
                }
            break;

            case 'pattern':
            default:
                $criteria = array('uri' => $uri);
                if(!empty($context)) { $criteria['context_key'] = $context; }
                $resource = $this->modx->getObject('modResource', $criteria);
                if(!empty($resource) && is_object($resource)) {
                    return false;
                }
            break;
        }
        return true;
    }
}

return 'RedirectorImportCSVProcessor';