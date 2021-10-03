      function getnextId(arr) {
          arr.sort();
          for (var i = 0; i < arr.length - 1; i++) {
              if (arr[i] + 1 != arr[i + 1])
                  return arr[i] + 1;
          }
          return arr[arr.length - 1] + 1;
      }

      function addHardware() {
          var $searchdiv = $('div[id^="hwid"]:last');
          var divs = [];
          $('div[id^="hwid"]').each(function() {
              divs.push(parseInt(this.id.replace(/hwid/, '')));
          });

          var nextId = getnextId(divs);
		  console.log(nextId);
          if (divs.length < 8) {
              var $cloneSelect = $searchdiv.clone().prop('id', 'hwid' + nextId).prop('name', 'hwid' + nextId);
              $cloneSelect.find("[id*='hwselectid']").prop('id', 'hwselectid' + nextId);
              $cloneSelect.find("#hwselectid" + (nextId)).attr('name', 'hwselectid' + nextId);
              $cloneSelect.find("#hwlabel").remove();
              $cloneSelect.find("#removeButton").empty();
              $cloneSelect.find("#removeButton").append(" <input type='button' class='btn btn-danger ' onclick='removeHardware(" + nextId + ")' value='Remove'>");
              $cloneSelect.clone().insertAfter($searchdiv);
          }
      }

      function removeHardware(id) {
          $("#hwid" + id).remove();
      }




      $(document).ready(function() {
          $('#wordlistTable').DataTable({
              "bFilter": false,
              "bSearchable": false,
              "bInfo": false,
              "bPaginate": false,
			  "order": [[ 1, "desc" ]],
              "aoColumnDefs": [{
                  'bSortable': false,
                  'aTargets': [0, 4, 5]
              }]
          })
      });