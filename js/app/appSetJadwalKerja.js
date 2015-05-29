/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var kodeJadwal = [
    {'id':"N", 'text':'Normal'},
    {'id':"S", 'text':'Shift'}
];
  
$(document).ready(function()
{
    $('#tblSetJadwalKerja').tablesorter({
        headers: 
        { 
            8: {sorter: false} 
        }
    });
    
    $('#txtJenisJadwal').select2(
    {
        placeholder: "Kode Jadwal",
        minimumInputLength: 0,
        data:{results : kodeJadwal}
    });
    
    if(typeof pathJad != 'undefined')
    {
        $('#txtKaryawan').select2(
        {
            placeholder: "Karyawan",
            minimumInputLength: 0,
            ajax: 
            {
                url: pathJad+"/sKaryawan",
                dataType: 'json',         
                data: function (term, page) 
                {                
                    return { q : term, key:$("#txtId").val()  }
                },
                results: function(data, page ) 
                {
                    return { results: data }
                }
            },
            initSelection: function(element, callback) 
            {
                var q = $(element).val();

                if(q!="")
                {
                    $.ajax( 
                    {                    
                        url: pathJad+"/sKaryawan",
                        dataType: 'json',
                        data: {id: q, key:$("#txtId").val()}
                    }).done(function(data){ callback(data[0]); });
                }
            }
        });
    }
    
    if(typeof pathJad != 'undefined')
    {
        $('#txtJadwal').select2(
        {
            placeholder: "Jadwal",
            minimumInputLength: 0,
            ajax: 
            {
                url: pathJad+"/sJadwal",
                dataType: 'json',         
                data: function (term, page) 
                {                
                    return { q : term,type:$("#txtJenisJadwal").val()  }
                },
                results: function(data, page ) 
                {
                    return { results: data }
                }
            },
            initSelection: function(element, callback) 
            {
                var q = $(element).val();

                if(q!="")
                {
                    $.ajax( 
                    {                    
                        url: pathJad+"/sJadwal",
                        dataType: 'json',
                        data: {id: q,type:$("#txtJenisJadwal").val()}
                    }).done(function(data){ callback(data[0]); });
                }
            }
        });
    }
    
    $('#formSetJadwalKerja').bootstrapValidator({
        message: 'Nilai Tidak Valid!',
        feedbackIcons: 
        {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: 
        {
            txtKaryawan:
            {
                validators:
                {
                    notEmpty:
                    {
                        message:"Karyawan Harus Dipilih!"
                    }
                }
            },
            txtJenisJadwal:
            {
                validators:
                {
                    notEmpty:
                    {
                        message:"Jenis Jadwal Harus Dipilih!"
                    }
                }
            },
            txtJadwal:
            {
                validators:
                {
                    notEmpty:
                    {
                        message:"Jadwal Harus Dipilih!"
                    }
                }
            }
        }
    });
    
    $('#txtKaryawan').on('change show', function(e) 
    {
        // Validate the date when user change it
        $('#formSetJadwalKerja')
            // Get the bootstrapValidator instance
            .data('bootstrapValidator')
            // Mark the field as not validated, so it'll be re-validated when the user change date
            .updateStatus('txtKaryawan', 'NOT_VALIDATED', null)
            // Validate the field
            .validateField('txtKaryawan');
    });
    
    $('#txtJenisJadwal').on('change show', function(e) 
    {
        // Validate the date when user change it
        $('#formSetJadwalKerja')
            // Get the bootstrapValidator instance
            .data('bootstrapValidator')
            // Mark the field as not validated, so it'll be re-validated when the user change date
            .updateStatus('txtJenisJadwal', 'NOT_VALIDATED', null)
            // Validate the field
            .validateField('txtJenisJadwal');
    });
    
    $('#txtJadwal').on('change show', function(e) 
    {
        // Validate the date when user change it
        $('#formSetJadwalKerja')
            // Get the bootstrapValidator instance
            .data('bootstrapValidator')
            // Mark the field as not validated, so it'll be re-validated when the user change date
            .updateStatus('txtJadwal', 'NOT_VALIDATED', null)
            // Validate the field
            .validateField('txtJadwal');
    });
    
});