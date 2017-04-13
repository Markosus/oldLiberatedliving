<script> 
      $(document).ready(function(){ 
      $('a#pagination').bind('click',function(event){ 
      event.preventDefault(); 
        $.get(this.href,{},function(response){  
         $('#ajaxresults').html(response) 
        })   
     }) 
    }); 
</script>  
<?php




 
  class pagination
  {
    var $page = 1; // Current Page
    var $perPage = 3; // Items on each page, defaulted to 10
    var $showFirstAndLast = false; // if you would like the first and last page options.
     
    function generate($array, $perPage = 3)
    {
      // Assign the items per page variable
      if (!empty($perPage))
        $this->perPage = $perPage;
       
      // Assign the page variable
      if (!empty($_GET['pagenum'])) {
        $this->page = $_GET['pagenum']; // using the get method
      } else {
        $this->page = 1; // if we don't have a page number then assume we are on the first page
      }
       
      // Take the length of the array
      $this->length = count($array);
       
      // Get the number of pages
      $this->pages = ceil($this->length / $this->perPage);
       
      // Calculate the starting point 
      $this->start  = ceil(($this->page - 1) * $this->perPage);
       
      // Return the part of the array we have requested
      return array_slice($array, $this->start, $this->perPage);
    }
     
    function links()
    {
      // Initiate the links array
      $plinks = array();
      $links = array();
      $slinks = array();
       
      // Concatenate the get variables to add to the page numbering string
      if (count($_GET)) {
        $queryURL = '';
        foreach ($_GET as $key => $value) {
          if ($key != 'pagenum') {
            $queryURL .= '&'.$key.'='.$value;
          }
        }
      }
       
      // If we have more then one pages
      if (($this->pages) > 1)
      {
        // Assign the 'previous page' link into the array if we are not on the first page
        if ($this->page != 1) {
          if ($this->showFirstAndLast) {
            $plinks[] = ' <a id="pagination" href="testajaxtemp?pagenum=1'.$queryURL.'"><div class="paginationbuttons">First </div></a> ';
          }
          $plinks[] = ' <a id="pagination" href="testajaxtemp?pagenum='.($this->page - 1).$queryURL.'"><div class="paginationbuttons">Prev</div></a> ';
        }
         
        // Assign all the page numbers & links to the array
        for ($j = 1; $j < ($this->pages + 1); $j++) {
          if ($this->page == $j) {
            $links[] = ' <a id="pagination" class="selected"><div class="paginationbuttons">'.$j.'</div></a> '; // If we are on the same page as the current item
          } else {
            $links[] = ' <a id="pagination" href="testajaxtemp?pagenum='.$j.$queryURL.'"><div class="paginationbuttons">'.$j.'</div></a> '; // add the link to the array
          }
        }
   
        // Assign the 'next page' if we are not on the last page
        if ($this->page < $this->pages) {
          $slinks[] = ' <a id="pagination" href="testajaxtemp?pagenum='.($this->page + 1).$queryURL.'"> <div class="paginationbuttons">Next</div></a> ';
           // $slinks[] = ' <a href="?pagenum='.($this->page + 1).$queryURL.'"> <div class="paginationbuttons">Next</div></a> ';
          if ($this->showFirstAndLast) {
            $slinks[] = ' <a id="pagination" href="testajaxtemp?pagenum='.($this->pages).$queryURL.'"> <div class="paginationbuttons">Last</div></a> ';
          }
        }
         
        // Push the array into a string using any some glue
        return implode(' ', $plinks).implode($this->implodeBy, $links).implode(' ', $slinks);
      }
      return;
    }
  }
?>
