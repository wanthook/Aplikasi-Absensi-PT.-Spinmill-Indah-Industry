/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var paramCo = "TAlasan";

$(document).ready(function()
{
//    $('#tblAlasan').tablesorter({
//        headers: 
//        { 
//            3: {sorter: false} 
//        }
//    });

    $('#txtTgl,#txtTglSearch').datepicker({format:'dd-mm-yyyy'});
    
    $('#cmbAlasan,#cmbAlasanSearch').select2(
    {
        placeholder: "Pilih Alasan",
        minimumInputLength: 0,
        ajax: 
        {
            url: siteUrl+"/transaksi_alasan/sAlasan",
            dataType: 'json',         
            data: function (term, page) 
            {                
                return { q : term  }
            },
            results: function(data, page ) 
            {
                return { results: data }
            }
        },
        initSelection: function(element, callback) 
        {
            var id = $(element).val();
            
            if(id!="")
            {
                $.ajax( 
                {                    
                    url: siteUrl+"/transaksi_alasan/sAlasan",
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $('#cmbKaryawan').select2(
    {
        placeholder: "Pilih Karyawan",
        minimumInputLength: 3,
        ajax: 
        {
            url: siteUrl+"/transaksi_alasan/sKaryawan",
            dataType: 'json',         
            data: function (term, page) 
            {                
                return { q : term  }
            },
            results: function(data, page ) 
            {
                return { results: data }
            }
        },
        initSelection: function(element, callback) 
        {
            var id = $(element).val();
            
            if(id!="")
            {
                $.ajax( 
                {                    
                    url: siteUrl+"/transaksi_alasan/sKaryawan",
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $("#txtWaktu").mask("00.00");
    
    $('#formTransaksiAlasan').bootstrapValidator({
        message: 'Nilai Tidak Valid!',
        feedbackIcons: 
        {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: 
        {
            txtTgl:
            {
                validators:
                {
                    notEmpty:
                    {
                        message:"Tanggal Harus Dipilih!"
                    },
                    date: 
                    {
                        format: "dd-mm-YYYY",
                        message: "Format tanggal tidak valid!"
                    }
                }
            },
            cmbAlasan:
            {
                validators:
                {
                    notEmpty:
                    {
                        message:"Alasan Harus Dipilih!"
                    }
                }
            },
            cmbKaryawan:
            {
                validators:
                {
                    notEmpty:
                    {
                        message:"Karyawan Harus Dipilih!"
                    }
                }
            },
            txtWaktu:
            {
                validators:
                {
                    notEmpty:
                    {
                        message:"Waktu Harus Diisi!"
                    }
                }
            }
        }
    });
    
    $('#txtTgl').on('change show', function(e) 
    {
        // Validate the date when user change it
        $('#formTransaksiAlasan')
            // Get the bootstrapValidator instance
            .data('bootstrapValidator')
            // Mark the field as not validated, so it'll be re-validated when the user change date
            .updateStatus('txtTgl', 'NOT_VALIDATED', null)
            // Validate the field
            .validateField('txtTgl');
    });
    
    $('#cmbAlasan').on('change show', function(e) 
    {
        // Validate the date when user change it
        $('#formTransaksiAlasan')
            // Get the bootstrapValidator instance
            .data('bootstrapValidator')
            // Mark the field as not validated, so it'll be re-validated when the user change date
            .updateStatus('cmbAlasan', 'NOT_VALIDATED', null)
            // Validate the field
            .validateField('cmbAlasan');
    });
    
    $('#cmbKaryawan').on('change show', function(e) 
    {
        // Validate the date when user change it
        $('#formTransaksiAlasan')
            // Get the bootstrapValidator instance
            .data('bootstrapValidator')
            // Mark the field as not validated, so it'll be re-validated when the user change date
            .updateStatus('cmbKaryawan', 'NOT_VALIDATED', null)
            // Validate the field
            .validateField('cmbKaryawan');
    });
    
    if($.cookie('txtTgl'+paramCo) !== undefined)
    {
        $('#txtTglSearch').val($.cookie('txtTgl'+paramCo));
    }
        
    if($.cookie('txtSearch'+paramCo) !== undefined)
    {
        $('#txtSearch').val($.cookie('txtSearch'+paramCo));
    }
    
    if($.cookie('cmbAlasan'+paramCo) !== undefined)
    {
        $('#cmbAlasanSearch').val($.cookie('cmbAlasan'+paramCo));
    }
//    console.log($.cookie('txtTgl'+paramCo));
    $("#formSearchTransaksiAlasan").submit(function(e)
    {
        $.cookie('txtTgl'+paramCo, $('#txtTglSearch').val());
        $.cookie('txtSearch'+paramCo, $('#txtSearch').val());
        $.cookie('cmbAlasan'+paramCo, $('#cmbAlasanSearch').val());
    });
});

