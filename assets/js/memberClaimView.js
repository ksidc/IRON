$(function(){
    $(".btn-claim-modify").click(function(){
        if(confirm("청구 내용을 수정하시겠습니까?")){
            var url = "/api/paymentUpdate";
            var datas = $("#payForm").serialize();
            // console.log(datas);
            // return false;
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    console.log(response);
                    if(response.result)
                        document.location.reload();
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    })
})