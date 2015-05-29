/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function()
{

    $('#txtPeriode').datepicker({
        format:'mm-yyyy',
        viewMode: "months", 
        minViewMode: "months"});
    
        
    $('#cmbKaryawan').select2(
    {
        placeholder: "Pilih Karyawan",
        minimumInputLength: 3,
        ajax: 
        {
            url: siteUrl+"/proses_absensi/sKaryawan",
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
                    url: siteUrl+"/proses_absensi/sKaryawan",
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $('#cmbDivisi').select2(
    {
        placeholder: "Pilih Divisi",
        minimumInputLength: 0,
        ajax: 
        {
            url: siteUrl+"/karyawan/sDivisi",
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
                    url: siteUrl+"/karyawan/sDivisi",
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
//    
    $('#cmbLaporan').on('change show', function(e) 
    {
        // Validate the date when user change it
        $('#formLaporanAbsenKaryawan')
            // Get the bootstrapValidator instance
            .data('bootstrapValidator')
            // Mark the field as not validated, so it'll be re-validated when the user change date
            .updateStatus('cmbLaporan', 'NOT_VALIDATED', null)
            // Validate the field
            .validateField('cmbLaporan');
    });
});

