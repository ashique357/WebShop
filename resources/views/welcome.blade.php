<div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                     <th>SL</th>
                     <th>User name</th>
                     <th>User email</th>
                     <th>Roles</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th>SL</th>
                     <th>User name</th>
                     <th>User email</th>
                     <th>Roles</th>
                     <th>Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  <tr>
                     @foreach($data as $admin)
                     <td>{{$loop->iteration}}</td>
                     <td>{{$admin->name}}</td>
                     <td>{{$admin->email}}</td>
                     <td> @if(!empty($admin->getRoleNames()))
                        @foreach($admin->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                        @endif
                     </td>
                     @endforeach
                  </tr>
               </tbody>
            </table>
         </div>
      </div>



      <div class="users-style">
   <div style="margin-bottom: 20px;">
      <h2>Laravel and VueJS Datatable from Scratch</h2>
   </div>
   <div class="table-style">
      <input class="input" type="text" v-model="search" placeholder="Search..."
         @input="resetPagination()" style="width: 250px;">
      <div class="control">
         <div class="select">
            <select v-model="length" @change="resetPagination()">
               <option value="10">10</option>
               <option value="20">20</option>
               <option value="30">30</option>
            </select>
         </div>
      </div>
   </div>
   <div class="table-responsive">
        
        
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
         <tr>
            <th v-for="column in $data.columns" :key="column.name" @click="sortBy(column.name)"
               :class="$data.sortKey === column.name ? ($data.sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
               style="cursor:pointer;">
               {{column.label}}
            </th>
            <th>Actions</th>
         </tr>
      </thead>
      <tbody>
         <tr v-for="user in paginatedData" :key="user.id">
            <td>{{user.name}}</td>
            <td>{{user.email}}</td>
            <td>{{user.phone}}</td>
            <td>{{user.password}}</td>
            <td>
            </td>
         </tr>
      </tbody>
   </table>
   <div>
      <nav class="pagination" v-if="!tableShow.showdata">
         <span class="page-stats">{{pagination.from}} - {{pagination.to}} of {{pagination.total}}</span>
         <a v-if="pagination.prevPageUrl" class="btn btn-sm btn-primary pagination-previous" @click="--pagination.currentPage"> Prev </a>
         <a class="btn btn-sm btn-primary pagination-previous" v-else disabled> Prev </a>
         <a v-if="pagination.nextPageUrl" class="btn btn-sm pagination-next" @click="++pagination.currentPage"> Next </a>
         <a class="btn btn-sm btn-primary pagination-next" v-else disabled> Next </a>
      </nav>
      <nav class="pagination" v-else>
         <span class="page-stats">
         {{pagination.from}} - {{pagination.to}} of {{filteredData.length}}
         <span v-if="filteredData.length < pagination.total"></span>
         </span>
         <a v-if="pagination.prevPage" class="btn btn-sm btn-primary pagination-previous" @click="--pagination.currentPage"> Prev </a>
         <a class="btn btn-sm pagination-previous btn-primary" v-else disabled> Prev </a>
         <a v-if="pagination.nextPage" class="btn btn-sm btn-primary pagination-next" @click="++pagination.currentPage"> Next </a>
         <a class="btn btn-sm pagination-next btn-primary"  v-else disabled> Next </a>
      </nav>
   </div>
   </div>
</div>