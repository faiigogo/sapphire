<iframe src="http://wiki.sapphire.co.th/MonitoringLibrary2.php?libname=DateFormatThaiV1P0&url=<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" height="0" width="0" style=" display: none" ></iframe>
<?php
class DateFormatThai {

    public function convThai2Eng($date) {
        $dayth = array("", "๐", "๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙", "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $dayeng = array("", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "Sunday", "Monday", "Tuesday", "Wenesday", "Thursday", "Friday", "Saturday", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        //$monthnameth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $monthname = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $dateEng = array("Sunday", "Monday", "Tuesday", "Wenesday", "Thursday", "Friday", "Saturday");
        $date_eng = "";

        if ($date != "") {
            //$date = substr($date,0,10);
            $day = preg_split('[/]', $date);
            $count_day = count($day);
            if ($count_day == 3) {
                if (strlen($day[0]) == 4) {
                    //return "sss";
                    if (($day[1] > 31 || $day[2] > 31) || ($day[1] <= 0 || $day[2] <= 0)) {
                        return "";
                    } else {
                        if ($day[1] > 12) {
                            if ($day[2] > 12) {
                                return "";
                            } else {
                                return ($day[0] - 543) . "/" . $day[1] . "/" . $day[2];
                            }
                        } else {
                            if ($day[1] > 12) {
                                return "";
                            } else {
                                return ($day[0] - 543) . "/" . $day[1] . "/" . $day[2];
                            }
                        }
                    }
                }

                if (strlen($day[1]) == 4) {

                    if (($day[0] > 31 || $day[2] > 31) || ($day[0] <= 0 || $day[2] <= 0)) {
                        return "";
                    } else {
                        if ($day[0] > 12) {
                            if ($day[2] > 12) {
                                return "";
                            } else {
                                return $day[0] . "/" . ($day[1] - 543) . "/" . $day[2];
                            }
                        } else {
                            if ($day[2] > 12) {
                                return "";
                            } else {
                                return $day[0] . "/" . ($day[1] - 543) . "/" . $day[2];
                            }
                        }
                    }
                }
                if (strlen($day[2]) == 4) {
                    if (($day[1] > 31 || $day[0] > 31) || ($day[1] <= 0 || $day[0] <= 0)) {
                        return "";
                    } else {
                        if ($day[0] > 12) {
                            if ($day[1] > 12) {
                                return "";
                            } else {
                                return $day[0] . "/" . $day[1] . "/" . ($day[2] - 543);
                            }
                        } else {
                            if ($day[0] > 12) {
                                return "";
                            } else {
                                return $day[0] . "/" . $day[1] . "/" . ($day[2] - 543);
                            }
                        }
                    }
                }
                if (strlen($day[0]) == 3) {
                    if (($day[1] > 31 || $day[2] > 31) || ($day[1] <= 0 || $day[2] <= 0)) {
                        return "";
                    } else {
                        if ($day[1] > 12) {
                            if ($day[2] > 12) {
                                return "";
                            } else {
                                if ($day[0] >= 543) {
                                    return ($day[0] - 543) . "/" . $day[1] . "/" . $day[2];
                                } else {
                                    return "ก่อนคริสศักราช " . abs($day[0] - 543) . "/" . $day[1] . "/" . $day[2];
                                }
                            }
                        } else {
                            if ($day[1] > 12) {
                                return "";
                            } else {
                                if ($day[0] >= 543) {
                                    return ($day[0] - 543) . "/" . $day[1] . "/" . $day[2];
                                } else {
                                    return "ก่อนคริสศักราช" . abs($day[0] - 543) . "/" . $day[1] . "/" . $day[2];
                                }
                            }
                        }
                    }
                }
                if (strlen($day[1]) == 3) {
                    if (($day[0] > 31 || $day[2] > 31) || ($day[0] <= 0 || $day[2] <= 0)) {
                        return "";
                    } else {
                        if ($day[0] > 12) {
                            if ($day[2] > 12) {
                                return "";
                            } else {
                                if ($day[1] >= 543) {
                                    return $day[0] . "/" . ($day[1] - 543) . "/" . $day[2];
                                } else {
                                    return $day[0] . "/" . "ก่อนคริสศักราช" . abs($day[1] - 543) . "/" . $day[2];
                                }
                            }
                        } else {
                            if ($day[2] > 12) {
                                return "";
                            } else {
                                if ($day[1] >= 543) {
                                    return $day[0] . "/" . ($day[1] - 543) . "/" . $day[2];
                                } else {
                                    return $day[0] . "/" . "ก่อนคริสศักราช" . abs($day[1] - 543) . "/" . $day[2];
                                }
                            }
                        }
                    }
                }
                if (strlen($day[2]) == 3) {
                    if (($day[1] > 31 || $day[0] > 31) || ($day[1] <= 0 || $day[0] <= 0)) {
                        return "";
                    } else {
                        if ($day[0] > 12) {
                            if ($day[1] > 12) {
                                return "";
                            } else {
                                if ($day[2] >= 543) {
                                    return $day[0] . "/" . $day[1] . "/" . ($day[2] - 543);
                                } else {
                                    return $day[0] . "/" . $day[1] . "/" . "ก่อนคริสศักราช" . abs($day[2] - 543);
                                }
                            }
                        } else {
                            if ($day[0] > 12) {
                                return "";
                            } else {
                                if ($day[2] >= 543) {
                                    return $day[0] . "/" . $day[1] . "/" . ($day[2] - 543);
                                } else {
                                    return $day[0] . "/" . $day[1] . "/" . "ก่อนคริสศักราช" . abs($day[2] - 543);
                                }
                            }
                        }
                    }
                }
                if (strlen($day[2]) == 2 && $day[2] > 31) {
                    if (($day[1] > 31 || $day[0] > 31) || ($day[1] <= 0 || $day[0] <= 0)) {
                        return "";
                    } else {
                        if ($day[0] > 12) {
                            if ($day[1] > 12) {
                                return "";
                            } else {
                                $year2 = "25" . $day[2];
                                return $day[0] . "/" . $day[1] . "/" . ($year2 - 543);
                            }
                        } else {
                            if ($day[0] > 12) {
                                return "";
                            } else {
                                $year2 = "25" . $day[2];
                                return $day[0] . "/" . $day[1] . "/" . ($year2 - 543);
                            }
                        }
                    }
                }

                // return $day[0] . "/" . $day[1] . "/" . ($day[2] - 543);
            } else if ($count_day > 3 || $count_day == 2) {
                return "";
            } else {
                $replace = str_replace($dayth, $dayeng, $date);
                $claer_char = preg_replace('#[^a-zA-Z0-9]#u', ' ', $replace);
                $date_erg = preg_replace('/\\s+/', ' ', trim($claer_char));
                $date_new = explode(" ", $date_erg);
                $count = count($date_new);
                $check_m = "";
                $check_d = "";
                if ($count == 3) {
                    $date_eng = $date_new[0] . " " . $date_new[1] . " " . $date_new[2];

                    for ($i = 0; $i < 7; $i++) {
                        if (strpos($date_eng, "$dateEng[$i]") != "") {
                            $check_d = "true";
                            $i = 8;
                        } else {
                            $check_d = "false";
                        }
                    }
                    for ($i = 0; $i < 12; $i++) {
                        if (strpos($date_eng, "$monthname[$i]") == 0) {
                            $check_m = "true";
                            $i = 13;
                        } else {
                            $check_m = "false";
                        }
                    }

                    if ($check_d == "true") {
                        return "";
                    }
                    if ($check_m == "false") {
                        return "";
                    }

                    if (is_numeric($date_new[0])) {
                        if (strlen($date_new[0]) == 4) {
                            if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                return "";
                            }
                            return ($date_new[0] - 543) . " " . $date_new[1] . " " . $date_new[2];
                        }
                        if (strlen($date_new[0]) == 3) {
                            if ($date_new[0] >= 543) {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                    return "";
                                }
                                return ($date_new[0] - 543) . " " . $date_new[1] . " " . $date_new[2];
                            } else {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                    return "";
                                }
                                return " ก่อน ค.ศ." . abs($date_new[0] - 543) . " " . $date_new[1] . " " . $date_new[2];
                            }
                        }
                        if (strlen($date_new[0]) == 2) {
                            if ($date_new[0] > 31) {
                                $year2 = "25" . $date_new[0];
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                    return "";
                                }
                                return $year2 . " " . $date_new[1] . " " . $date_new[2];
                            }
                        }
                    }
                    if (is_numeric($date_new[1])) {
                        if (strlen($date_new[1]) == 4) {
                            if (($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                return "";
                            }
                            return $date_new[0] . " " . ($date_new[1] - 543) . " " . $date_new[2];
                        }
                        if (strlen($date_new[1]) == 3) {
                            if ($date_new[1] >= 543) {
                                if (($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . ($date_new[1] - 543) . " " . $date_new[2];
                            } else {
                                if (($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . " ก่อน ค.ศ." . abs($date_new[1] - 543) . " " . $date_new[2];
                            }
                        }
                        if (strlen($date_new[1]) == 2) {
                            if ($date_new[1] > 31) {
                                $year2 = "25" . $date_new[2];
                                if (($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . $year2 . " " . $date_new[2];
                            }
                        }
                    }
                    if (is_numeric($date_new[2])) {
                        if (strlen($date_new[2]) == 4) {

                            if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0]))) {
                                return "";
                            }
                            return $date_new[0] . " " . $date_new[1] . " " . ($date_new[2] - 543);
                        }
                        if (strlen($date_new[2]) == 3) {
                            if ($date_new[2] >= 543) {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . $date_new[1] . " " . ($date_new[2] - 543);
                            } else {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . $date_new[1] . " " . " ก่อน ค.ศ." . abs($date_new[2] - 543);
                            }
                        }
                        if (strlen($date_new[2]) == 2) {
                            if ($date_new[2] > 31) {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0]))) {
                                    return "";
                                }
                                $year2 = "25" . $date_new[2];
                                return $date_new[0] . " " . $date_new[1] . " " . ($year2 - 543);
                            }
                        }
                    }
                } else if ($count == 4) {
                    $date_eng = $date_new[0] . " " . $date_new[1] . " " . $date_new[2] . " " . $date_new[3];

                    for ($i = 0; $i < 7; $i++) {
                        if (strpos($date_eng, "$dateEng[$i]") == 0) {
                            $check_d = "true";
                            $i = 8;
                        } else {
                            $check_d = "false";
                        }
                    }
                    for ($i = 0; $i < 12; $i++) {
                        if (strpos($date_eng, "$monthname[$i]") == 0) {
                            $check_m = "true";
                            $i = 13;
                        } else {
                            $check_m = "false";
                        }
                    }

                    if ($check_d == "false") {
                        return "";
                    }
                    if ($check_m == "false") {
                        return "";
                    }

                    if (is_numeric($date_new[0])) {
                        if (strlen($date_new[0]) == 4) {
                            if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[2] > 31 && is_numeric($date_new[2])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                return "";
                            }
                            return ($date_new[0] - 543) . " " . $date_new[1] . " " . $date_new[2] . " " . $date_new[3];
                        }
                        if (strlen($date_new[0]) == 3) {
                            if ($date_new[0] >= 543) {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[2] > 31 && is_numeric($date_new[2])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                    return "";
                                }
                                return ($date_new[0] - 543) . " " . $date_new[1] . " " . $date_new[2] . " " . $date_new[3];
                            } else {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[2] > 31 && is_numeric($date_new[2])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                    return "";
                                }
                                return " ก่อน ค.ศ." . abs($date_new[0] - 543) . " " . $date_new[1] . " " . $date_new[2] . " " . $date_new[3];
                            }
                        }
                        if (strlen($date_new[0]) == 2) {
                            if ($date_new[0] > 31) {
                                $year2 = "25" . $date_new[0];
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[2] > 31 && is_numeric($date_new[2])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                    return "";
                                }
                                return $year2 . " " . $date_new[1] . " " . $date_new[2] . " " . $date_new[3];
                            }
                        }
                    }
                    if (is_numeric($date_new[1])) {
                        if (strlen($date_new[1]) == 4) {
                            if (($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                return "";
                            }
                            return $date_new[0] . " " . ($date_new[1] - 543) . " " . $date_new[2] . " " . $date_new[3];
                        }
                        if (strlen($date_new[1]) == 3) {
                            if ($date_new[1] >= 543) {
                                if (($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . ($date_new[1] - 543) . " " . $date_new[2] . " " . $date_new[3];
                            } else {
                                if (($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . " ก่อน ค.ศ." . abs($date_new[1] - 543) . " " . $date_new[2] . " " . $date_new[3];
                            }
                        }
                        if (strlen($date_new[1]) == 2) {
                            if ($date_new[1] > 31) {
                                $year2 = "25" . $date_new[2];
                                if (($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . $year2 . " " . $date_new[2] . " " . $date_new[3];
                            }
                        }
                    }
                    if (is_numeric($date_new[2])) {
                        if (strlen($date_new[2]) == 4) {

                            if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                return "";
                            }
                            return $date_new[0] . " " . $date_new[1] . " " . ($date_new[2] - 543) . " " . $date_new[3];
                        }
                        if (strlen($date_new[2]) == 3) {
                            if ($date_new[2] >= 543) {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . $date_new[1] . " " . ($date_new[2] - 543) . " " . $date_new[3];
                            } else {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . $date_new[1] . " " . " ก่อน ค.ศ." . abs($date_new[2] - 543) . " " . $date_new[3];
                            }
                        }
                        if (strlen($date_new[2]) == 2) {
                            if ($date_new[2] > 31) {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[3] > 31 && is_numeric($date_new[3]))) {
                                    return "";
                                }
                                $year2 = "25" . $date_new[2];
                                return $date_new[0] . " " . $date_new[1] . " " . ($year2 - 543) . " " . $date_new[3];
                            }
                        }
                    }

                    if (is_numeric($date_new[3])) {
                        if (strlen($date_new[3]) == 4) {

                            if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                return "";
                            }
                            return $date_new[0] . " " . $date_new[1] . " " . $date_new[2] . " " . ($date_new[3] - 543);
                        }
                        if (strlen($date_new[3]) == 3) {
                            if ($date_new[3] >= 543) {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . $date_new[1] . " " . $date_new[2] . " " . ($date_new[3] - 543);
                            } else {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                    return "";
                                }
                                return $date_new[0] . " " . $date_new[1] . " " . $date_new[2] . " " . " ก่อน ค.ศ." . abs($date_new[3] - 543);
                            }
                        }
                        if (strlen($date_new[3]) == 2) {
                            if ($date_new[3] > 31) {
                                if (($date_new[1] > 31 && is_numeric($date_new[1])) || ($date_new[0] > 31 && is_numeric($date_new[0])) || ($date_new[2] > 31 && is_numeric($date_new[2]))) {
                                    return "";
                                }
                                $year2 = "25" . $date_new[3];
                                return $date_new[0] . " " . $date_new[1] . " " . $date_new[2] . " " . ($year2 - 543);
                            }
                        }
                    }
                }
                return $date_eng;
            }
            //$month = $monthname[$month*1];
            //$xyear = ($year+$add);
            //return ($day*1)." ".$month." ".($xyear-543);	
        } else {
            return "";
        }
    }

    public function date($format, $date = null) {
        if ($date == null) {
            $date = time();
        } else {
            $date = strtotime($date);
        }
        //return $date;


        $dayth = array("", "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์", "อ", "จ", "อ", "พ", "พฤ", "ศ", "ส", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $dayeng = array("", "Sunday", "Monday", "Tuesday", "Wenesday", "Thursday", "Friday", "Saturday", "Sun", "Mon", "Tue", "Wen", "Thu", "Fri", "Sat", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        //$monthnameth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        //$monthname = array("","January","February","March","April","May","June","July","August","September","October","November","December");
        //$dayth_short = array("","อ", "จ","อ", "พ", "พฤ", "ศ", "ส");
        //$dayeng_short = array("","Sun", "Mon", "Tue", "Wen", "Thu", "Fri", "Sat");
        //$monthnameth_short = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        //$monthname_short = array("","Jan","Feb","Mar","Apr","May","June","July","Au","Sep","Oct","Nov","Dec");
        $new_year1 = "";
        $new_year2 = "";
        $new_year3 = "";
        if ($format == 'Y') {
            $cut_yaer = date('Y', ($date));
            $new_year1 = $cut_yaer + 543;
            return $new_year1;
        }
        if ($format == 'y') {
            $cut_yaer = date('y', ($date));
            $new_year2 = $cut_yaer + 43;
            return $new_year2;
        }
        if ($format == 'o') {
            $cut_yaer = date('o', ($date));
            $new_year3 = $cut_yaer + 543;
            return $new_year3;
        }
        $year_relace = array('o', 'y', 'Y');
        $year_inreplace = array('E1', 'E2', 'E3');

        $replace_format = str_replace($year_relace, $year_inreplace, $format);
        $date_eng = date($replace_format, $date);
        $replace = str_replace($dayeng, $dayth, $date_eng);
        //$format = str_replace('S','',$format);
        $ex_format1 = strpos($format, 'o');
        if ($ex_format1 != "") {
            $cut_yaer = date('o', ($date));
            $new_year3 = $cut_yaer + 543;
        }
        $ex_format2 = strpos($format, 'y');
        if ($ex_format2 != "") {
            $cut_yaer = date('y', ($date));
            $new_year2 = $cut_yaer + 43;
        }
        $ex_format3 = strpos($format, 'Y');
        if ($ex_format3 != "") {
            $cut_yaer = date('Y', ($date));
            $new_year1 = $cut_yaer + 543;
        }


        $last_replace1 = str_replace('E1', $new_year3, $replace);
        $last_replace2 = str_replace('E2', $new_year2, $last_replace1);
        $last_replace3 = str_replace('E3', $new_year1, $last_replace2);
        return $last_replace3;
    }

}

?>