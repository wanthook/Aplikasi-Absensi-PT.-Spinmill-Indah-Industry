/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function()
{
    $('#tblLibur').tablesorter({
        headers: 
        { 
            3: {sorter: false} 
        }
    });
//    $('#txtTanggalLibur,#txtKeteranganLibur').mask('00:00:00');
    $('#txtTanggalLibur').datepicker(
    {
        format: 'dd-mm-yyyy'
    });
});

