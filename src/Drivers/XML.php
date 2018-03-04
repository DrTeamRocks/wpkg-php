<?php namespace WPKG\Drivers;

use \Spatie\ArrayToXml\ArrayToXml;
use \WPKG\Interfaces\Export;

class XML implements Export
{
    public function build(array $array, string $mode): string
    {
        // Get parameters of current class
        $driver = "WPKG\\Drivers\\XML\\$mode";
        $driver = new $driver();

        // Set root parameter
        $root = [
            'rootElementName' => $driver::ROOT,
            '_attributes' => $driver::ROOT_ATTRIBUTES
        ];

        // Serialization
        $array = $this->serialize($array);

        // Generate XML
        $xml = ArrayToXml::convert($array, $root, true, 'UTF-8');

        // Make more readable
        return $this->prettify($xml);
    }

    /**
     * Make XML more readable
     *
     * @param   string $xml
     * @return  string
     */
    private function prettify(string $xml): string
    {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);
        return $dom->saveXML();
    }

    private function serialize(array $array)
    {
        $out = [];
        foreach ($array as $a_key => $a_value) {
            switch (true) {

                case ($a_key == 'package'):
                    foreach ($a_value as $v_key => $v_value) {
                        if (isset($v_value['checks'])) {
                            foreach ($v_value['checks'] as $c_key => $c_value) {
                                foreach ($c_value as $c_item) {
                                    $out[$a_key][$v_key]['check'][]['_attributes'] = array_merge(['type' => $c_key], $c_item);
                                }
                            }
                            unset($v_value['checks']);
                        }

                        // Parse commands array
                        if (isset($v_value['commands'])) {
                            // Every command must be a single element
                            foreach ($v_value['commands'] as $c_key => $c_value) {
                                foreach ($c_value as $c_item) {
                                    $array = [];
                                    // Parse exit codes
                                    if (isset($c_item['exits'])) {
                                        foreach ($c_item['exits'] as $exit) {
                                            $array['exit'][]['_attributes'] = $exit;
                                        }
                                        // We need unset original array with exits from source array
                                        unset($c_item['exits']);
                                    }
                                    $array['_attributes'] = array_merge(['type' => $c_key], $c_item);
                                    $out[$a_key][$v_key]['commands']['command'][] = $array;
                                }
                            }
                            // Unset original commands from source array
                            unset($v_value['commands']);
                        }

                        $out[$a_key][$v_key]['_attributes'] = $v_value;
                    }
                    break;

                case ($a_key == 'profile'):
                    foreach ($a_value as $v_key => $v_value) {
                        $out[$a_key][$v_key]['_attributes']['id'] = $v_value['id'];

                        if (isset($v_value['depends'])) {
                            if (!is_array($v_value['depends'])) {
                                $out[$a_key][$v_key]['depends'][]['_attributes']['profile-id'] = $v_value['depends'];
                            } else {
                                foreach ($v_value['depends'] as $depend) {
                                    $out[$a_key][$v_key]['depends'][]['_attributes']['profile-id'] = $depend;
                                }
                            }
                        }

                        if (isset($v_value['packages'])) {
                            if (!is_array($v_value['packages'])) {
                                $out[$a_key][$v_key]['package'][]['_attributes']['package-id'] = $v_value['packages'];
                            } else {
                                foreach ($v_value['packages'] as $package) {
                                    $out[$a_key][$v_key]['package'][]['_attributes']['package-id'] = $package;
                                }
                            }
                        }
                    }
                    break;

                case ($a_key == 'host'):
                    foreach ($a_value as $v_key => $v_value) {
                        if (!is_array($v_value['profile-id'])) {
                            $out[$a_key][$v_key]['_attributes'] = $v_value;
                        } else {
                            $out[$a_key][$v_key]['_attributes'] = [
                                'name' => $v_value['name'],
                                'profile-id' => $v_value['profile-id'][0]
                            ];
                            unset($v_value['profile-id'][0]);
                            foreach ($v_value['profile-id'] as $profile) {
                                $out[$a_key][$v_key]['profile'][] = ['_attributes' => ['profile-id' => $profile]];
                            }
                        }
                    }
                    break;

                case ($a_key == 'param'):
                    foreach ($a_value as $v_key => $v_value) {
                        $out[$a_key][$v_key]['_attributes'] = $v_value;
                    }
                    break;

                case ($a_key == 'variables'):
                    foreach ($a_value as $v_key => $v_value) {
                        $out[$a_key]['variable'][$v_key]['_attributes'] = $v_value;
                    }
                    break;

                case ($a_key == 'languages'):
                    foreach ($a_value as $v_key => $v_value) {
                        $out[$a_key]['language'][$v_key]['_attributes'] = ['lcid' => $v_value['lcid']];

                        foreach ($v_value['strings'] as $string) {
                            $out[$a_key]['language'][$v_key]['string'][] = [
                                '_attributes' => ['id' => $string['id']],
                                '_cdata' => $string['text']
                            ];
                        }
                    }
                    break;
            }
        }

        return $out;
    }
}
