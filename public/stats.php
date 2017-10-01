<!DOCTYPE html>
<html>
    <head>
        <title>Financial Insight</title>
        <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Financial Insight</h1>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Dates and Days</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="input-group date">
                                    <span class="input-group-addon" style="width: 130px;">
                                        <span>Today</span>
                                    </span>
                                    <input type="text" class="form-control today" value="<?php echo date("d.m.Y"); ?>" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group date">
                                    <span class="input-group-addon" style="width: 130px;">
                                        <span>Date of Birth</span>
                                    </span>
                                    <input type="text" class="form-control dob" value="03.11.1991" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group date">
                                    <span class="input-group-addon" style="width: 130px;">
                                        <span>Deadline</span>
                                    </span>
                                    <input type="text" class="form-control deadline" value="03.11.2020" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="width: 130px;">Days Left</span>
                                            <input type="text" class="form-control days-left" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="width: 130px;">Days Required</span>
                                            <input type="text" class="form-control days-required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="width: 130px;">Extra Days</span>
                                            <input type="text" class="form-control extra-days" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="width: 130px;">Extra Years</span>
                                            <input type="text" class="form-control extra-years" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group date">
                                    <span class="input-group-addon" style="width: 130px;">
                                        <span>Date of Success</span>
                                    </span>
                                    <input type="text" class="form-control date-of-success" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group" style="width: 100%;">
                                    <span class="input-group-addon" style="width: 130px;">Age at success</span>
                                    <input type="text" class="form-control age-at-success"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cashflow</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="input-group" style="width: 100%;">
                                    <span class="input-group-addon" style="width: 150px;">Current Wealth</span>
                                    <input type="text" class="form-control current-wealth" value="61000"/>
                                    <span class="input-group-addon">$</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group" style="width: 100%;">
                                    <span class="input-group-addon" style="width: 150px;">Target Wealth</span>
                                    <input type="text" class="form-control target-wealth" value="1000000"/>
                                    <span class="input-group-addon">$</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group" style="width: 100%;">
                                    <span class="input-group-addon" style="width: 150px;">Need More</span>
                                    <input type="text" class="form-control needed-wealth"/>
                                    <span class="input-group-addon">$</span>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <div class="input-group" style="width: 100%;">
                                    <span class="input-group-addon" style="width: 150px;">Hourly Revenue</span>
                                    <input type="text" class="form-control hourly-revenue rate"/>
                                    <span class="input-group-addon">$</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group" style="width: 100%;">
                                    <span class="input-group-addon" style="width: 150px;">Daily Revenue</span>
                                    <input type="text" class="form-control daily-revenue rate"/>
                                    <span class="input-group-addon">$</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group" style="width: 100%;">
                                    <span class="input-group-addon" style="width: 150px;">Monthly Revenue</span>
                                    <input type="text" class="form-control monthly-revenue rate"/>
                                    <span class="input-group-addon">$</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group" style="width: 100%;">
                                    <span class="input-group-addon" style="width: 150px;">Yearly Revenue</span>
                                    <input type="text" class="form-control yearly-revenue rate" value="42800" />
                                    <span class="input-group-addon">$</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $('.date').datepicker({format: 'dd.mm.yyyy'});
                loadStats();
                
                $('.rate').on('blur', function() {
                    $('.rate').not(this).val('');
                    loadStats();
                });
                
                $('input').not('.rate').on('blur', function() {
                    loadStats();
                })
            });
            
            function loadStats() {
                var today = $('.today').val();
                var dob = $('.dob').val();
                var deadline = $('.deadline').val();
                
                var temp = today.split('.');
                today = new Date(temp[2], temp[1]-1, temp[0]);
                temp = dob.split('.');
                dob = new Date(temp[2], temp[1]-1, temp[0]);
                temp = deadline.split('.');
                deadline = new Date(temp[2], temp[1]-1, temp[0]);

                var daysLeft = Math.round((deadline - today)/(1000*60*60*24));
                $('.days-left').val(daysLeft);
                
                var hourlyRate = $('.hourly-revenue').val();
                var dailyRate = $('.daily-revenue').val();
                var monthlyRate = $('.monthly-revenue').val();
                var yearlyRate = $('.yearly-revenue').val();
                
                if (hourlyRate) {
                    dailyRate = (8 * hourlyRate).toFixed(2);
                    yearlyRate = (40 * 52 * hourlyRate).toFixed(2);
                    monthlyRate = (yearlyRate / 12).toFixed(2);
                    $('.daily-revenue').val(dailyRate);
                    $('.monthly-revenue').val(monthlyRate);
                    $('.yearly-revenue').val(yearlyRate);
                } else if (dailyRate) {
                    hourlyRate = (dailyRate / 8).toFixed(2);
                    yearlyRate = (40 * 52 * hourlyRate).toFixed(2);
                    monthlyRate = (yearlyRate / 12).toFixed(2);
                    $('.hourly-revenue').val(hourlyRate);
                    $('.monthly-revenue').val(monthlyRate);
                    $('.yearly-revenue').val(yearlyRate);
                } else if (monthlyRate) {
                    yearlyRate = (monthlyRate * 12).toFixed(2);
                    hourlyRate = (yearlyRate / 2080).toFixed(2);
                    dailyRate = (8 * hourlyRate).toFixed(2);
                    $('.hourly-revenue').val(hourlyRate);
                    $('.daily-revenue').val(dailyRate);
                    $('.yearly-revenue').val(yearlyRate);
                } else if (yearlyRate) {
                    hourlyRate = (yearlyRate / 2080).toFixed(2);
                    dailyRate = (8 * hourlyRate).toFixed(2);
                    monthlyRate = (yearlyRate / 12).toFixed(2);
                    $('.hourly-revenue').val(hourlyRate);
                    $('.daily-revenue').val(dailyRate);
                    $('.monthly-revenue').val(monthlyRate);
                }
                
                var currentWealth = $('.current-wealth').val();
                var targetWealth = $('.target-wealth').val();
                var neededWealth = targetWealth - currentWealth;
                $('.needed-wealth').val(neededWealth);
                
                var daysRequired  = Math.round(neededWealth / dailyRate);
                $('.days-required').val(daysRequired);
                
                var dayDifference = daysRequired - daysLeft;
                $('.extra-days').val(dayDifference);
                
                var yearDifference = (dayDifference / 365.25).toFixed(2);
                $('.extra-years').val(yearDifference);
                
                var dateOfAchievement = new Date(today.getTime());
                dateOfAchievement.setDate(today.getDate() + daysRequired);
                var doaString = dateOfAchievement.toISOString().slice(0, 10);
                doaString = doaString.split('-');
                $('.date-of-success').val(doaString[2] + '.' + doaString[1] + '.' + doaString[0]);
                
                var ageDifference = dateOfAchievement.getTime() - dob.getTime();
                var ageDate = new Date(ageDifference);
                var ageAtSuccess = Math.abs(ageDate.getUTCFullYear() - 1970);
                $('.age-at-success').val(ageAtSuccess);
            }
        </script>
    </body>
</html>