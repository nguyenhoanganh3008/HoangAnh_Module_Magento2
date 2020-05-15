
<?php
    $weather_object = $this->getWeatherInformation(); 
    $weather_data = json_decode(json_encode($weather_object),true);
    $week_day = ['Chủ nhật','Thứ hai','Thứ ba','Thứ tư','Thứ năm','Thứ sáu','Thứ bảy'];
    $date = getdate();
    $thu = $week_day[$date['wday']];
    
    $thang = $date['mon'];
    $nam = $date['year'];
    $ngay = $date['mday'] . '/' . $thang . '/' . $nam;
    $string_date = $date['mday'].'-'.$thang.'-'.$nam;
    $dateVal1 = date_create(date('d-m-Y'));
    $dateVal2 = date_create(date('d-m-Y'));
    $dateVal3 = date_create(date('d-m-Y'));
    $dateVal4 = date_create(date('d-m-Y'));
    // $tempeFmin = $weather_data['DailyForecasts']['Temperature']['Minimum']['Value'];
    // $tempeCmin = (int) ($tempeFmin-32)*(5/9);
    // $tempeFmax = $weather_data['DailyForecasts']['Temperature']['Maximum']['Value'];
    // $tempeCmax = (int) ($tempeFmax-32)*(5/9);

    // lấy danh sách icon
 
    $listIconDay = [];
    $dem0 = 0;
    foreach ($weather_data['DailyForecasts'] as $value) {
        $icon = $value['Day']['Icon'];
        $listIconDay[$dem0] = $icon;
        $dem0++;
    }
    $listIconNight = [];
    $dem3 = 0;
    foreach ($weather_data['DailyForecasts'] as $value) {
        $icon = $value['Night']['Icon'];
        $listIconNight[$dem3] = $icon;
        $dem3++;
    }
    //  lấy link ảnh của icon

    function getLinkIcon($iconId){
        if($iconId<10){
            return '"'.'https://developer.accuweather.com/sites/default/files/0' . $iconId .'-s.png' . '"';
        }
        else{
            return '"'.'https://developer.accuweather.com/sites/default/files/' . $iconId .'-s.png' . '"';
        }
    }

    //lấy trạng thái thời tiết 
    // ngày
    $listStatusTempDay = [];
    $dem4 = 0;
    foreach ($weather_data['DailyForecasts'] as $value) {
        $icon = $value['Day']['IconPhrase'];
        $listStatusTempDay[$dem4] = $icon;
        $dem4++;
    }
    // đêm
    $listStatusTempNight = [];
    $dem5 = 0;
    foreach ($weather_data['DailyForecasts'] as $value) {
        $icon = $value['Night']['IconPhrase'];
        $listStatusTempNight[$dem5] = $icon;
        $dem5++;
    }

    // lấy danh sách nhiệt độ cho 5 ngày
    $listTemCMin = [];
    $dem1=0;
    $dem2=0;
    $listTemCMax = [];
    foreach ($weather_data['DailyForecasts'] as $value) {
        $tempeFmin = $value['Temperature']['Minimum']['Value'];
        $tempeCmin = ($tempeFmin-32)*(5/9);
        $listTemCMin[$dem1] = round($tempeCmin);
        $dem1++;
    }
    foreach ($weather_data['DailyForecasts'] as $value) {
        $tempeFmax = $value['Temperature']['Maximum']['Value'];
        $tempeCmax = ($tempeFmax-32)*(5/9);
        $listTemCMax[$dem2] = round($tempeCmax) ;
        $dem2++;
    }
?>

<div class="weather_block" style="background-color: wheat;
                                    height: 340px;
                                    width: 500px;">
        <p style="font-weight: 700;
                font-size: 15px;
                margin-left : 20px;">Thời gian : <?php print_r($thu); ?> <?php print_r($string_date) ?> </p>
        <p style="font-weight: 700;
        font-size: 15px;
        margin-left : 20px;">Dự báo hôm nay :  <?php print_r($weather_data['Headline']['Text']) ?> </p>
         <p style="font-weight: 700;
                font-size: 15px;
                margin-left : 20px;">Nhiệt độ :  </p>
        <p style="font-weight: 700;
        font-size: 15px;
        margin-left: 90px;">
                       Nhiệt độ thấp nhất :  <?php print_r($listTemCMin[0]); ?> &ordmC</p>
        <p style="font-weight: 700;
        font-size: 15px;
        margin-left: 90px;">
                       Nhiệt độ cao nhất : <?php print_r($listTemCMax[0]); ?> &ordmC</p>
        <p style="font-weight: 700;
        font-size: 15px;
        margin-left : 20px;">Ngày : 
                 <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconDay[0])) ?> width="75" height="45" alt="Sunny" title="Sunny" />  
                 -----------
                 <?php print_r($listStatusTempDay[0]) ?>
            </p>
        <p style="font-weight: 700;
        font-size: 15px;
        margin-left : 20px;">Đêm :
                 <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconNight[0])) ?> width="75" height="45" alt="Sunny" title="Sunny" />  
                 -----------
                 <?php print_r($listStatusTempNight[0]) ?>
        </p>
</div>

<div class="weather_ngay2" style="background-color: wheat;
                                        height: 70px;
                                        width: 500px;
                                        margin-left: 600px;
                                        position: absolute;
                                        top: 25%;
                                        right: 25%;">
                <p>
                    <label>
                      ---------------- <?php 
                            date_modify($dateVal1, "+1 days");
                            $ngay2Val = date_format($dateVal1, "d-m-Y");
                            $ngay2 = $week_day[$date['wday']+1] . "  " . $ngay2Val ;
                            print_r($ngay2); 
                        ?>
                      ----------------  </label>
                    <label>
                        Nhiệt độ : <?php 
                            print_r($listTemCMin[1]);
                        ?> &ordmC - 
                        <?php 
                            print_r($listTemCMax[1]); 
                        ?> &ordmC
                      ----------------   </label>
                    <label>
                    -------Ngày :
                        <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconDay[1])) ?> width="50" height="30" alt="Sunny" title="Sunny" />  
                        <?php print_r($listStatusTempDay[1]) ?>
                        -------   </label>
                    <label>
                        Đêm :
                        <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconNight[1])) ?> width="50" height="30" alt="Sunny" title="Sunny" />  
                        <?php print_r($listStatusTempNight[1]) ?>
                        -------  </label>
                </p>
        </div>
        <div class="weather_ngay3" style="background-color: wheat;
                                        height: 70px;
                                        width: 500px;
                                        margin-left: 600px;
                                        position: absolute;
                                        top: 34.5%;
                                        right: 25%;">
                <p>
                    <label>
                      ---------------- <?php 
                            date_modify($dateVal2, "+2 days");
                            $ngay3Val = date_format($dateVal2, "d-m-Y");
                            $ngay3 = $week_day[$date['wday']+2] . "  " . $ngay3Val ;
                            print_r($ngay3); 
                        ?>
                      ----------------  </label>
                    <label>
                        Nhiệt độ : <?php 
                            print_r($listTemCMin[2]);
                        ?> &ordmC - 
                        <?php 
                            print_r($listTemCMax[2]); 
                        ?> &ordmC
                      ----------------   </label>
                    <label>
                    -------Ngày :
                        <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconDay[2])) ?> width="50" height="30" alt="Sunny" title="Sunny" />  
                        <?php print_r($listStatusTempDay[2]) ?>
                        -------   </label>
                    <label>
                        Đêm :
                        <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconNight[2])) ?> width="50" height="30" alt="Sunny" title="Sunny" />  
                        <?php print_r($listStatusTempNight[2]) ?>
                        -------  </label>
                </p>
        </div>
        <div class="weather_ngay4" style="background-color: wheat;
                                        height: 70px;
                                        width: 500px;
                                        margin-left: 600px;
                                        position: absolute;
                                        top: 44%;
                                        right: 25%;">
                <p>
                    <label>
                      ---------------- <?php 
                            date_modify($dateVal3, "+3 days");
                            $ngay4Val = date_format($dateVal3, "d-m-Y");
                            $ngay4 = $week_day[$date['wday']+3] . "  " . $ngay4Val ;
                            print_r($ngay4); 
                        ?>
                      ----------------  </label>
                    <label>
                        Nhiệt độ : <?php 
                            print_r($listTemCMin[3]);
                        ?> &ordmC - 
                        <?php 
                            print_r($listTemCMax[3]); 
                        ?> &ordmC
                      ----------------   </label>
                    <label>
                    -------Ngày :
                        <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconDay[3])) ?> width="50" height="30" alt="Sunny" title="Sunny" />  
                        <?php print_r($listStatusTempDay[3]) ?>
                        -------   </label>
                    <label>
                        Đêm :
                        <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconNight[3])) ?> width="50" height="30" alt="Sunny" title="Sunny" />  
                        <?php print_r($listStatusTempNight[3]) ?>
                        -------  </label>
                </p>
        </div>
        <div class="weather_ngay5" style="background-color: wheat;
                                        height: 70px;
                                        width: 500px;
                                        margin-left: 600px;
                                        position: absolute;
                                        top: 53.5%;
                                        right: 25%;">
                <p>
                    <label>
                      ---------------- <?php 
                            date_modify($dateVal4, "+4 days");
                            $ngay5Val = date_format($dateVal4, "d-m-Y");
                            $ngay5 = $week_day[$date['wday']+4] . "  " . $ngay5Val ;
                            print_r($ngay5); 
                        ?>
                      ----------------  </label>
                    <label>
                        Nhiệt độ : <?php 
                            print_r($listTemCMin[4]);
                        ?> &ordmC - 
                        <?php 
                            print_r($listTemCMax[4]); 
                        ?> &ordmC
                      ----------------   </label>
                    <label>
                      -------Ngày :
                        <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconDay[4])) ?> width="50" height="30" alt="Sunny" title="Sunny" />  
                        <?php print_r($listStatusTempDay[4]) ?>
                        -------   </label>
                    <label>
                        Đêm :
                        <img typeof="foaf:Image" class="img-responsive" src=<?php print_r(getLinkIcon($listIconNight[4])) ?> width="50" height="30" alt="Sunny" title="Sunny" />  
                        <?php print_r($listStatusTempNight[4]) ?>
                        -------  </label>
                </p>
        </div>