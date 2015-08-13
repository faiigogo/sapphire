<!DOCTYPE html>
<html>
    <head>
        <meta charset='Windows-874' />
        <title>welcome</title>
        <script src="./SMLcore/TheirParty/js/jquery-1.8.1.min.js"></script>
    </head>
    <body>
        <b>ระบบกำลังทำงาน</b><br>
        <b>[INFO] : </b>กำลังโหลด cost task จากเครื่องเซริฟเวอร์ภายนอก...<br>
        <b>[INFO] : </b>กรุณารอสักครู่...<br>
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "http://202.129.35.101/cost_script/load_cost_task_sapphire.php?key=superSapphire",
                    dataType: 'jsonp',
                    success: function(json) {
                        $('body').append("<b>[COMPLETE] : </b>การโหลด cost task สำเร็จ !!! <br>");
                        $('body').append("<b>[INFO] : </b>กำลังสร้าง Array ข้อมูล... <br>");
                        var dataToSend = new Array();
                        dataToSend["data"] = new Array();
                        var dataindex = 0;
                        $.each(json, function(key, value) {
                            dataToSend["data"][dataindex] = value;
                            dataindex++;
                        });

                        $('body').append("<b>[COMPLETE] : </b>การสร้าง Array ข้อมูลสำเร็จ !!! <br>");
                        $('body').append("<b>[INFO] : </b>กำลังสร้างตารางฐานข้อมูลใหม่ กรุณารอสักครู่... <br>");
                        
                        dataToSend = JSON.stringify(dataToSend);
                        dataToSend = encodeURIComponent(dataToSend);

                        jQuery.ajax({
                            type: 'POST',
                            url: "./save_cost_task_sapphire_to_db.php",
                            data: dataToSend,
                            dataType: "html",
                            success: function(data) {
                                $('body').append("<b>[COMPLETE] : </b>การสร้างตารางฐานข้อมูลใหม่สำเร็จ !!! <br>");
                                $('body').append("<b>============= SUCCESS ===============</b>");
                                $('body').append(data);
                            },
                            error: function() {
                                $('body').append("<b>[ERROR] : </b>เกิดข้อผิดพลาด กรุณาติดต่อทีมพัฒนาระบบ !!! <br>");
                            }
                        });
                    },
                    error: function() {
                        $('body').append("<b>[ERROR] : </b>เกิดข้อผิดพลาด กรุณาติดต่อทีมพัฒนาระบบ !!! <br>");
                    }
                });
            });
        </script>
    </body>
</html>