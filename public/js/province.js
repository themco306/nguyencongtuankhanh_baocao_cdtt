$.get("https://vapi.vnappmob.com/api/province/",
    function (data) {
        
        let province = data.results;
        let province_li='<option value="">---Tỉnh/Thành phố---</option>';
        province.forEach(function(item) {
            province_li+=' <option value="'+item.province_id+'">'+item.province_name +'</option>';
        });
        $('#province').html(province_li).trigger('change');

    }
);

$('#province').on('change', function() {
    let province_id = $(this).val();
    $.get("https://vapi.vnappmob.com/api/province/district/" + province_id,
        function (data) {
            let district = data.results;
            let district_li=' <option value="">---Quận/Huyện---</option>';
            district.forEach(function(item) {
                district_li+=' <option value="'+item.district_id+'">'+item.district_name +'</option>';
            });
            $('#district').html(district_li).trigger('change');
        }
    );
});
$('#district').on('change', function() {
    let district_id = $(this).val();
    $.get("https://vapi.vnappmob.com/api/province/ward/" + district_id,
        function (data) {
            let ward = data.results;
            let ward_li=' <option value="">---Phường/Xã---</option>';
            ward.forEach(function(item) {
                ward_li+=' <option value="'+item.ward_id+'">'+item.ward_name +'</option>';
            });
            $('#ward').html(ward_li).trigger('change');
        }
    );
});