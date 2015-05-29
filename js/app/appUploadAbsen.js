/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  
$(document).ready(function()
{
    var actionForm = $("#formUploadAbsen").attr("action");
    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');
    
    $('#tblUploadAbsen').tablesorter({
        headers: 
        { 
            6: {sorter: false} 
        }
    });
    
    $("#txtPeriode").datepicker({format:'mm-yyyy'});
    
    $('#formUploadAbsen').bootstrapValidator({
        message: 'Nilai Tidak Valid!',
        feedbackIcons: 
        {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: 
        {
            txtFile:
            {
                validators:
                {
                    notEmpty:
                    {
                        message:"File Harus Dipilih!"
                    },
                    file: 
                    {
                        extension: 'mdb',
                        message: 'File Tidak Valid'
                    }
                }
            },
            txtPeriode:
            {
                validators:
                {
                    notEmpty:
                    {
                        message:"Periode Harus Diisi!"
                    },
                    date: 
                    {
                        format: "MM-YYYY",
                        message: "Format tanggal tidak valid!"
                    }
                }
            }
        }
    });
    
    $('#txtFile').on('change show', function(e) 
    {
        // Validate the date when user change it
        $('#formUploadAbsen')
            // Get the bootstrapValidator instance
            .data('bootstrapValidator')
            // Mark the field as not validated, so it'll be re-validated when the user change date
            .updateStatus('txtFile', 'NOT_VALIDATED', null)
            // Validate the field
            .validateField('txtFile');
    });
    
    $('#txtPeriode').on('change show', function(e) 
    {
        // Validate the date when user change it
        $('#formUploadAbsen')
            // Get the bootstrapValidator instance
            .data('bootstrapValidator')
            // Mark the field as not validated, so it'll be re-validated when the user change date
            .updateStatus('txtPeriode', 'NOT_VALIDATED', null)
            // Validate the field
            .validateField('txtPeriode');
    });
    
    $('#formUploadAbsen').ajaxForm(
    {       
        beforeSend: function() 
        {
            
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
            
        },
        uploadProgress: function(event, position, total, percentComplete) 
        {            
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
                    //console.log(percentVal, position, total);
            if(percentComplete==100)
                $.blockUI({ message: '<h3><img src="./images/loading.gif" /><br>Mohon Tunggu, data sedang disinkronkan...</h3>' }); 
        },
        success: function() 
        {
            var percentVal = '100%';
            bar.width(percentVal)
            percent.html(percentVal);            
        },
        complete: function(xhr) 
        {
            $.unblockUI();    
            status.html(xhr.responseText);
        },
//        beforeSubmit: validate,
        data: $(this).formSerialize()
    });
    
//    $("#formUploadAbsen").fileupload(
//    {
//        dataType : 'json',
//        autoUpload : false,
//        submit: function (e, data)
//        {
//            e.preventDefault();
//            console.log(data);
//        },
//        add: function (e, data) 
//        {
////            data.submit();
//        },
//        done: function (e, data) 
//        {
//            $.each(data.result.files, function (index, file) {
//                $('<p/>').text(file.name).appendTo('#files');
//            });
//        },
//        progressall: function (e, data) 
//        {
//            var progress = parseInt(data.loaded / data.total * 100, 10);
//            $('#progress .progress-bar').css(
//                'width',
//                progress + '%'
//            );
//        }
//    }).prop('disabled', !$.support.fileInput)
//        .parent().addClass($.support.fileInput ? undefined : 'disabled');
    
    
    $("#formUploadAbsen").submit(function(e)
    {
        e.preventDefault();
    });
    
});

function validate(event)
{
//    event.stopPropagation();
    
    $('#formUploadAbsen').bootstrapValidator('validate');
    return $('#formUploadAbsen').data('bootstrapValidator').isValid();
}