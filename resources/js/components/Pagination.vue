<template>
    <div class="row">
      <div class="col-sm-12 col-md-5">
         <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite" v-if="!tableShow.showdata">{{pagination.from}} - {{pagination.to}} of {{pagination.total}}</div>
        <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite" v-else>               {{pagination.from}} - {{pagination.to}} of {{filteredData.length}}
               <span v-if="filteredData.length < pagination.total"></span></div>
      </div>

      <div class="col-sm-12 col-md-12">
         <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
            <ul class="pagination" v-if="!tableShow.showdata">
               <li class="paginate_button page-item " v-if="pagination.prevPageUrl"><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  @click="--pagination.currentPage">Prev</a></li>
               <li class="paginate_button page-item " v-else disabled><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  >Prev</a></li>
               <li class="paginate_button page-item " v-if="pagination.nextPageUrl"><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  @click="++pagination.currentPage">Next</a></li>
                <li class="paginate_button page-item " v-else disabled><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  >Next</a></li>
            </ul>
            <ul class="pagination" v-else>
               <li class="paginate_button page-item " v-if="pagination.prevPage"><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  @click="--pagination.currentPage">Prev</a></li>
               <li class="paginate_button page-item " v-else disabled><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  >Prev</a></li>
               <li class="paginate_button page-item " v-if="pagination.nextPage"><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  @click="++pagination.currentPage">Next</a></li>
                <li class="paginate_button page-item " v-else disabled><a href="#" aria-controls="dataTable"  tabindex="0" class="page-link"  >Next</a></li>
               
            </ul>
         </div>
      </div>
   </div>
</template>

<script>
export default {
    name:Pagination,
}
</script>