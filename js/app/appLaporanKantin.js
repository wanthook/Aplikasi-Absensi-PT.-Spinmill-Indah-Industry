/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//var jenisLaporan = 
//[
//    {'id':'D', 'text':'Detail'},
//    {'id':'K', 'text':'Komulatif'}
//];

$(document).ready(function()
{

    $('#txtPeriode').datepicker({
        format:'dd-mm-yyyy'});
    
    
//    $('#cmbLaporan').select2
//    (
//        {
//            placeholder: "Pilih Jenis Laporan",
//            minimumInputLength: 0,
//            data:{results : jenisLaporan}
//        }
//    );
    
    $('#cmbKaryawan').select2(
    {
        placeholder: "Pilih Karyawan",
        minimumInputLength: 3,
        ajax: 
        {
            url: siteUrl+"/laporan_absen/sKaryawan",
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
                    url: siteUrl+"/laporan_absen/sKaryawan",
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $('#cmbVendor').select2(
    {
        placeholder: "Pilih Vendor",
        minimumInputLength: 0,
        ajax: 
        {
            url: siteUrl+"/vendor_kantin/sVendor",
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
                    url: siteUrl+"/vendor_kantin/sVendor",
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
//    $('#cmbLaporan').on('change show', function(e) 
//    {
//        // Validate the date when user change it
//        $('#formLaporanAbsenKaryawan')
//            // Get the bootstrapValidator instance
//            .data('bootstrapValidator')
//            // Mark the field as not validated, so it'll be re-validated when the user change date
//            .updateStatus('cmbLaporan', 'NOT_VALIDATED', null)
//            // Validate the field
//            .validateField('cmbLaporan');
//    });
});

