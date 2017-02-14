if (typeof usesgraphcrt == "undefined" || !usesgraphcrt) {
    var usesgraphcrt = {};
}

usesgraphcrt.certificateCreate = {
    init: function() {
        $(document).on('submit', '#certificateCreate form', this.addNew);
        $showTargetListModalBtn = $('[data-role=target-list-modal-btn]'),
            $targetListModal = $('[data-role=target-list-modal]'),
            $targetListModalTItle = $('[data-role=target-list-modal-title]'),
            $targetListModalContent = $('[data-role=target-list-modal-content]');
        console.log($showTargetListModalBtn);
        $showTargetListModalBtn.on('click',function(){
            var url = $(this).data('url');
            var targetModel = $(this).find('span').html();
            usesgraphcrt.certificateCreate.loadTargetListModalContent(url,targetModel);
        });
    },
    loadTargetListModalContent: function (url,targetModel) {
        
        $targetListModalTItle.html('Сертификат для: "'+targetModel+'"');
        $targetListModalContent.load(url);
        $targetListModal.modal('show');
    },
    addNew: function() {
        var form = $(this);
        var data = $(form).serialize();
        data = data+'&ajax=1';

        jQuery.post($(form).attr('action'), data,
            function(json) {
                if(json.result == 'success') {
                    $('#certificateCreate').modal('hide');
                    $('.place-for-new-certificate').val(json.certificate).focus().select();
                }
                else {
                    console.log(json.errors);
                    alert(json.errors);
                }

                return true;

            }, "json");

        return false;
    },
};

usesgraphcrt.certificateCreate.init();