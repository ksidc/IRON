$(function(){
    var url = "/api/companyTypeList";
    var typeSearchForm = $("#typeSearchForm").serialize();
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : typeSearchForm,
        success:function(response){
            var html ="";
            if(response.list.length == 0){
                html += "<tr><td colspan=4 align=center>검색결과가 없습니다.</td></tr>";
            }else{
                for(var i = 0; i < response.list.length;i++){
                    html += '<tr>\
                                <td><a href="javascript:void(0)" class="clickType" data-seq="'+response.list[i].ct_seq+'" data-name="'+response.list[i].ct_name+'">'+response.list[i].ct_code+'</a></td>\
                                <td>'+response.list[i].ct_name+'</td>\
                                <td class="editType" data-name="'+response.list[i].ct_name+'" data-seq="'+response.list[i].ct_seq+'"><i class="fas fa-edit"></i></td>\
                                <td class="deleteType" data-seq="'+response.list[i].ct_seq+'"><i class="fas fa-trash"></i></td>\
                            </tr>\
                    ';
                }
            }
            $("#modalSearchType").html(html);
            $("#addType").val(pad(response.nextCode,3));
            $("#ct_name").val("");
        }
    });

    var url = "/api/endUserList";
    var endSearchForm = $("#endSearchForm").serialize();
    // console.log(userSearchForm);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : endSearchForm,
        success:function(response){
            // console.log(response);
            var html ="";
            if(response.length == 0){
                html += "<tr><td colspan=4 align=center>검색결과가 없습니다.</td></tr>";
            }else{
                for(var i = 0; i < response.list.length;i++){
                    html += '<tr>\
                                <td><a href="javascript:void(0)" class="clickEnd" data-name="'+response.list[i].eu_name+'" data-seq="'+response.list[i].eu_seq+'">'+response.list[i].eu_code+'</a></td>\
                                <td>'+response.list[i].eu_name+'</td>\
                                <td class="editEnd" data-name="'+response.list[i].eu_name+'" data-seq="'+response.list[i].eu_seq+'"><i class="fas fa-edit"></i></td>\
                                <td class="deleteEnd" data-seq="'+response.list[i].eu_seq+'"><i class="fas fa-trash"></i></td>\
                            </tr>\
                    ';
                }
            }
            $("#modalSearchEnd").html(html);
        }
    });
})