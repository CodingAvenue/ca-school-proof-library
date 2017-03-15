<?php

namespace CodingAvenue\Proof;

class Analyzer {

    private $file;

    public function __construct(string $file)
    {
        if (!file_exists($file)) {
            throw new \Exception("file $file not found.");
        }

        $this->file = $file;
    }

    public function codingConvention(): array
    {
        $phpcs = VendorBin::getCS();
        $command = sprintf("%s -q --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1 --report=json --standard=PSR2 %s 2>&1", $phpcs, $self->file);

        exec($command, $output, $exitCode);

        if ($exitCode !== 0 ) {
            throw new \Exception($output[0]);
        }

        $snifferOutput = json_decode($output[0], true);
        $csOutput = [ 'isCompliant' => true ];

        foreach ($snifferOutput['files'] as $file) {
            foreach ($file['messages'] as $message) {
                $csOutput['isCompliant'] = false;

                $csOutput['violations'][] = [
                    'message'   => $message['message'],
                    'line'      => $message['line'],
                    'column'    => $message['column']
                ];
            }
        }

        return $csOutput;   
    }

    public function messDetection(): array
    {
        $phpmd = VendorBin::getMD();
        $command = sprintf("%s %s xml cleancode,codesize,controversial,design,naming,unusedcode --ignore-violations-on-exit 2>&1", $phpmd, $this->file);

        exec($command, $output, $exitCode);

        if ($exitCode !== 0) {
            throw new \Exception($output[0]);
        }

        $xml = simplexml_load_string(implode("", $output));

        $mdOutput = [ 'messDetected' => false ];

        if ($xml->file) {
            foreach($xml->file->children() as $violation) {
                $mdOutput['messDetected'] = true;

                $mdOutput['violations'][] = [
                    'message' => $violation,
                    'beginLine' => $violation['beginline'],
                    'endLine'   => $violation['endline']
                ];
            }
        }

        return $mdOutput;
    }
}
