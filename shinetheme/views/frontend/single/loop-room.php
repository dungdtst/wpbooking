<?php
$list_extra = array();
$list_extra = get_post_meta(get_the_ID(),'extra_services',true);

?>
<div class="loop-room post-<?php the_ID() ?>">
    <div class="room-image">
        <img class="" src="http://localhost/shinetheme/traveler-booking/wp-content/uploads/2016/08/12122691_1656913957929210_758468824321059402_n-150x150.jpg">
    </div>
    <div class="room-content">
        <div class="room-title">
            <?php the_title() ?>
        </div>
        <div class="room-info">
            <div class="control left">
                <?php
                $max_guests = get_post_meta(get_the_ID(),'max_guests',true);
                if(!empty($max_guests)){
                    ?>
                    <div class="img">
                        <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0ODcuOTAxIDQ4Ny45MDEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4Ny45MDEgNDg3LjkwMTsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTQ3NC4yLDMwMy44MDFjLTM4LjktMzItODAuOS01My45LTkyLjYtNTkuN3YtNTguMmM4LjMtNi43LDEzLjItMTYuOCwxMy4yLTI3LjZ2LTY1LjVjMC0zNS44LTI5LjEtNjUtNjUtNjVoLTE0LjEgICAgYy0zNS44LDAtNjUsMjkuMS02NSw2NXY2NS41YzAsMTAuOCw0LjksMjAuOSwxMy4yLDI3LjZ2NTguMmMtMTEuNyw1LjgtNTMuNywyNy43LTkyLjYsNTkuN2MtOC43LDcuMi0xMy43LDE3LjgtMTMuNywyOS4ydjQ0LjkgICAgYzAsMy4zLDIuNyw2LDYsNmMzLjMsMCw2LTIuNyw2LTZ2LTQ0LjljMC03LjgsMy40LTE1LDkuMy0xOS45YzQwLjItMzMsODMuNy01NSw5Mi01OWMzLjEtMS41LDUtNC42LDUtOHYtNjMuMWMwLTItMS0zLjktMi43LTUgICAgYy02LjYtNC40LTEwLjUtMTEuNy0xMC41LTE5LjZ2LTY1LjVjMC0yOS4yLDIzLjgtNTMsNTMtNTNoMTQuMWMyOS4yLDAsNTMsMjMuOCw1Myw1M3Y2NS41YzAsNy45LTMuOSwxNS4yLTEwLjUsMTkuNiAgICBjLTEuNywxLjEtMi43LDMtMi43LDV2NjMuMWMwLDMuNCwxLjksNi41LDUsOGM4LjMsNC4xLDUxLjksMjYsOTIsNTljNS45LDQuOSw5LjMsMTIuMSw5LjMsMTkuOXY0NC45YzAsMy4zLDIuNyw2LDYsNnM2LTIuNyw2LTYgICAgdi00NC45QzQ4OCwzMjEuNjAxLDQ4MywzMTEuMDAxLDQ3NC4yLDMwMy44MDF6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNMTQxLjQsOTIuMDAxaC0xMS41Yy0yOS44LDAtNTQsMjQuMi01NCw1NHY1My4zYzAsOC45LDQsMTcuMywxMC43LDIzdjQ2LjJjLTEwLjMsNS4yLTQzLjksMjIuOS03NSw0OC40ICAgIGMtNy40LDYuMS0xMS42LDE1LTExLjYsMjQuNnYzNi41YzAuMiwzLjIsMi45LDUuOSw2LjIsNS45YzMuMywwLDYtMi43LDYtNnYtMzYuNWMwLTYsMi42LTExLjYsNy4yLTE1LjMgICAgYzMyLjYtMjYuOCw2OC00NC42LDc0LjctNDcuOWMyLjktMS40LDQuNy00LjMsNC43LTcuNXYtNTEuNGMwLTItMS0zLjktMi43LTVjLTUtMy40LTguMS05LTguMS0xNXYtNTMuM2MwLTIzLjIsMTguOS00Miw0Mi00MiAgICBoMTEuNWMyMy4yLDAsNDIsMTguOSw0Miw0MnY1My4zYzAsNi0zLDExLjctOC4xLDE1Yy0xLjcsMS4xLTIuNywzLTIuNyw1djQyLjJjMCwzLjMsMi43LDYsNiw2YzMuMywwLDYtMi43LDYtNnYtMzkuMiAgICBjNi44LTUuNywxMC43LTE0LjEsMTAuNy0yM3YtNTMuM0MxOTUuNCwxMTYuMjAxLDE3MS4yLDkyLjAwMSwxNDEuNCw5Mi4wMDF6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNMzUwLjUsMjY0LjMwMWMwLTMuNC0yLjctNi4xLTYtNi4xcy02LDIuNy02LDZjMCw4LjYtNywxNS43LTE1LjcsMTUuN2MtMy4zLDAtNi40LTEuMS05LTIuOGMtMC40LTAuNS0wLjktMC45LTEuNS0xLjIgICAgYy0zLjItMi45LTUuMi03LTUuMi0xMS42YzAtMy4zLTIuNy02LTYtNnMtNiwyLjctNiw2YzAsNy42LDMuMSwxNC41LDguMSwxOS41bC02LjgsMTUxYy0wLjEsMS44LDAuNiwzLjUsMiw0LjdsMjEuMSwxOS4xICAgIGMxLjEsMSwyLjYsMS41LDQsMS41YzEuNCwwLDIuOS0wLjUsNC0xLjVsMjAuOC0xOC44YzEuMy0xLjIsMi4xLTIuOSwyLTQuN2wtNi42LTE1Mi43QzM0Ny45LDI3Ny41MDEsMzUwLjUsMjcxLjIwMSwzNTAuNSwyNjQuMzAxICAgIHogTTMyMy41LDQ0Ni4wMDFsLTE1LTEzLjVsNi40LTE0MS43YzIuNSwwLjcsNS4xLDEuMiw3LjksMS4yYzMuMiwwLDYuMy0wLjYsOS4yLTEuNmw2LjEsMTQyLjVMMzIzLjUsNDQ2LjAwMXoiIGZpbGw9IiMwMDAwMDAiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                    </div>
                    <?php esc_html_e("Max","wpbooking") ?> <?php echo $max_guests; ?>
                <?php } ?>
            </div>
            <div class="control">
                <?php
                $room_size = get_post_meta(get_the_ID(),'room_size',true);
                if(!empty($room_size)) {
                    ?>
                    <div class="img">
                        <img
                            src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTcuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ0Ny4wMjEgNDQ3LjAyMSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDQ3LjAyMSA0NDcuMDIxOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij4KPGc+Cgk8cGF0aCBkPSJNNDQ2LjkwOCw3LjU5OWMtMC4wMDItNC4xMzktMy4zNTctNy40OTQtNy40OTYtNy40OTZMMjQ3LjUxLDBjLTEyLjk1OCwwLTIzLjUsMTAuNTQyLTIzLjUsMjMuNXY0OCAgIGMwLDEyLjk1OCwxMC41NDIsMjMuNSwyMy41LDIzLjVoMzcuODk1TDk1LjAxNiwyODUuNDA4bDAuMDE0LTQ1Ljk2NEM5NC45OTksMjI2LjUxNyw4NC40NTcsMjE2LDcxLjUzLDIxNkgyMy41MSAgIGMtNi4yODMsMC0xMi4xODgsMi40NDgtMTYuNjI4LDYuODk0Yy00LjQ0LDQuNDQ2LTYuODgsMTAuMzU0LTYuODcyLDE2LjYzMWwwLjEwMywxOTkuODk3YzAuMDAyLDQuMTM5LDMuMzU3LDcuNDk0LDcuNDk2LDcuNDk2ICAgbDE5MS45MDEsMC4xMDNjMTIuOTU4LDAsMjMuNS0xMC41NDIsMjMuNS0yMy41di00OGMwLTEyLjk1OC0xMC41NDItMjMuNS0yMy41LTIzLjVoLTM3Ljg5NWwxOTAuMzg5LTE5MC40MDhsLTAuMDE0LDQ1Ljk2MyAgIGMwLjAzMSwxMi45MjcsMTAuNTczLDIzLjQ0NCwyMy41LDIzLjQ0NGg0OC4wMmM2LjI4MywwLDEyLjE4OC0yLjQ0OCwxNi42MjgtNi44OTRjNC40NC00LjQ0Niw2Ljg4LTEwLjM1NCw2Ljg3Mi0xNi42MzEgICBMNDQ2LjkwOCw3LjU5OXogTTQyOS41MjUsMjEzLjUyN2MtMS42MDYsMS42MDgtMy43NDIsMi40OTQtNi4wMTUsMi40OTRoLTQ4LjAyYy00LjY3NiwwLTguNDg5LTMuODA0LTguNS04LjQ1OWwwLjAyLTY0LjA1OSAgIGMwLjAwMS0zLjAzNC0xLjgyNi01Ljc3LTQuNjI5LTYuOTMxYy0yLjgwMi0xLjE2Mi02LjAyOS0wLjUyLTguMTc1LDEuNjI1bC0yMTYsMjE2LjAyMWMtMi4xNDUsMi4xNDUtMi43ODYsNS4zNzEtMS42MjUsOC4xNzMgICBjMS4xNjEsMi44MDMsMy44OTYsNC42Myw2LjkyOSw0LjYzaDU2YzQuNjg3LDAsOC41LDMuODEzLDguNSw4LjV2NDhjMCw0LjY4Ny0zLjgxMyw4LjUtOC40OTYsOC41bC0xODQuNDA1LTAuMDk5TDE1LjAxLDIzOS41MTEgICBjLTAuMDAzLTIuMjcyLDAuODgtNC40MSwyLjQ4NS02LjAxOGMxLjYwNi0xLjYwOCwzLjc0Mi0yLjQ5NCw2LjAxNS0yLjQ5NGg0OC4wMmM0LjY3NiwwLDguNDg5LDMuODA0LDguNSw4LjQ1OWwtMC4wMiw2NC4wNTkgICBjLTAuMDAxLDMuMDM0LDEuODI2LDUuNzcsNC42MjksNi45MzFjMi44MDIsMS4xNjEsNi4wMjksMC41Miw4LjE3NS0xLjYyNWwyMTYtMjE2LjAyMWMyLjE0NS0yLjE0NSwyLjc4Ni01LjM3MSwxLjYyNS04LjE3MyAgIGMtMS4xNjEtMi44MDMtMy44OTYtNC42My02LjkyOS00LjYzaC01NmMtNC42ODcsMC04LjUtMy44MTMtOC41LTguNXYtNDhjMC00LjY4NywzLjgxMy04LjUsOC40OTYtOC41bDE4NC40MDUsMC4wOTlsMC4wOTksMTkyLjQxMSAgIEM0MzIuMDEzLDIwOS43ODIsNDMxLjEzMSwyMTEuOTE5LDQyOS41MjUsMjEzLjUyN3oiIGZpbGw9IiMwMDAwMDAiLz4KCTxwYXRoIGQ9Ik01NS41MSwyNDcuNDUzYy00LjE0MiwwLTcuNSwzLjM1OC03LjUsNy41djU2LjU2OGMwLDQuMTQyLDMuMzU4LDcuNSw3LjUsNy41czcuNS0zLjM1OCw3LjUtNy41di01Ni41NjggICBDNjMuMDEsMjUwLjgxMSw1OS42NTMsMjQ3LjQ1Myw1NS41MSwyNDcuNDUzeiIgZmlsbD0iIzAwMDAwMCIvPgoJPHBhdGggZD0iTTQwNy41MSw0OC4wMjFjLTQuMTQyLDAtNy41LDMuMzU4LTcuNSw3LjV2ODBjMCw0LjE0MiwzLjM1OCw3LjUsNy41LDcuNXM3LjUtMy4zNTgsNy41LTcuNXYtODAgICBDNDE1LjAxLDUxLjM3OSw0MTEuNjUzLDQ4LjAyMSw0MDcuNTEsNDguMDIxeiIgZmlsbD0iIzAwMDAwMCIvPgoJPHBhdGggZD0iTTQwNy41MSwxNjAuMDIxYy00LjE0MiwwLTcuNSwzLjM1OC03LjUsNy41djE2YzAsNC4xNDIsMy4zNTgsNy41LDcuNSw3LjVzNy41LTMuMzU4LDcuNS03LjV2LTE2ICAgQzQxNS4wMSwxNjMuMzc5LDQxMS42NTMsMTYwLjAyMSw0MDcuNTEsMTYwLjAyMXoiIGZpbGw9IiMwMDAwMDAiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K"/>
                    </div>
                    <?php
                    echo $room_size;
                    $room_measunit = get_post_meta( $hotel_id , 'room_measunit' , true );
                    if($room_measunit == 'feed')
                        echo ' ft<sup>2</sup>';
                    else echo ' m<sup>2</sup>';
                }
                ?>
            </div>
        </div>
        <div class="room-facilities">
            <?php $facilities = get_post_meta(get_the_ID(),'taxonomy_room',true); ?>
            <?php  if(!empty($facilities)){ ?>
                <div class="title"><?php esc_html_e("Facilities","wpbooking") ?>:</div>
                <div class="facilities">
                    <?php
                    $html = '';
                    foreach($facilities as $taxonomy=>$term_ids){
                        foreach($term_ids as $key=>$value){
                            $term = get_term($value,$taxonomy);
                            $html .= $term->name.", ";
                        }
                    }
                    $html = substr($html,0,-2);
                    echo balanceTags($html);
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="room-book">
        <div class="room-total-price">
            <?php
            $price = get_post_meta(get_the_ID(),'base_price',true);
            echo WPBooking_Currency::format_money($price);
            ?>
        </div>
        <div class="room-number">
            <select class="form-control option_number_room" name="option_number_room" data-price-base="<?php echo esc_attr($price) ?>">
                <?php
                for($i=0;$i<20;$i++){
                    echo "<option value='{$i}'>{$i}</option>";
                }
                ?>
            </select>
        </div>
        <div class="room-extra">
            <?php if(!empty($list_extra)){ ?>
                <span class="btn_extra"><?php esc_html_e("Extra services","wpbooking") ?></span>
            <?php } ?>
        </div>
    </div>
    <div class="more-extra">
        <?php if(!empty($list_extra)){
            ?>
            <table>
                <thead>
                <tr>
                    <td width="10%">

                    </td>
                    <td width="50%">
                        <?php esc_html_e("Service name",'wpbooking') ?>
                    </td>
                    <td class="text-center">
                        <?php esc_html_e("Quantity",'wpbooking') ?>
                    </td>
                    <td class="text-center">
                        <?php esc_html_e("Price $",'wpbooking') ?>
                    </td>
                </tr>
                </thead>
                <tbody>
                <?php foreach($list_extra as $k=>$v){?>
                    <tr>
                        <td class="text-center">
                            <input class="option_is_extra" type="checkbox" <?php if($v['require'] == 'yes') echo 'checked onclick="return false"'; ?>  name="extra[<?php echo esc_attr($v['is_selected'])?>]">
                        </td>
                        <td>
                            <span class="title"><?php echo  esc_html($v['is_selected'])?></span>
                            <span class="desc"><?php echo esc_html( $v['desc'] ) ?></span>
                        </td>
                        <td>
                            <select class="form-control option_extra_quantity" name="extra[quantity]" data-price-extra="<?php echo esc_attr($v['money']) ?>">
                                <?php
                                $start = 0;
                                if($v['require'] == 'yes') $start = 1;
                                for($i=$start;$i<=$v['quantity'];$i++){
                                    echo "<option value='{$i}'>{$i}</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td class="text-center text-color">
                            <?php echo WPBooking_Currency::format_money($v['money']); ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>