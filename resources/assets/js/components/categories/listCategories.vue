<template>
  <div>
      <notifications group="foo" />
      <part-tooltip></part-tooltip>

      <categories-form></categories-form>

      <part-panel>
        <p slot="heading">Categories List</p>
        <div slot="body">
          <div class="row">
            <div class="col-md-4">
            </div>
              <div class="col-md-3">
                  <button class="btn btn-success btn-block" @click='showModal()'>
                    <i class="fa fa-plus"></i>
                    &nbsp;&nbsp;ADD NEW CATEGORY
                  </button>
              </div>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                  <table class="table table-fixed" id="categoriesTable">
                      <thead><tr>
                          <th class="col-xs-1">#ID</th>
                          <th class="col-xs-2">Name</th>
                          <th class="col-xs-2">Description</th>
                          <th class="col-xs-1">Order</th>
                          <th class="col-xs-1">State</th>
                          <th class="col-xs-2">Date</th>
                          <th class="col-xs-2" style="text-align: center;">action</th>
                      </tr>

                      </thead>
                      <tbody>
                        <tr v-for="category in categories" v-bind:class="[category.state ? 'success' : 'danger']">
                            <td class="col-xs-1">{{ category.id }}</td>
                            <td class="col-xs-2">{{ category.name }}</td>
                            <td class="col-xs-2">{{ category.desc }}</td>
                            <td class="col-xs-1">{{ category.order }}</td>
                            <td class="col-xs-1">
                              <span v-bind:class="[category.state ? 'bg-green' : 'bg-red', 'label']" v-text="category.state ? 'Enabled' : 'Disabled'"></span>
                            </td>
                            <td class="col-xs-2">{{ category.created_at }}</td>
                            <td class="col-xs-2" style="text-align: center;">
                                <button class="btn" @click="editCategory(category)" data-toggle="tooltip" title="Edit category"><i class="fa fa-icon fa-edit"></i></button>
                                <button class="btn" @click="enableCategory(category)" v-bind:title="[category.state ? 'Enable category' : 'Disable category']"  data-toggle="tooltip">
                                  <i v-bind:class="[category.state ? 'fa-unlock' : 'fa-lock', 'fa fa-icon']"></i>
                                </button>
                                <button class="btn" @click="destroyCategory(category)" data-toggle="tooltip" title="Delete category"><i class="fa fa-icon fa-trash"></i></button>
                            </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
      </part-panel>

  </div>


</template>

<script>

    export default {

        data() {
            return {
                categories: [],
                dtHandle:'',
            };
        },

        created(){
            Event.$on('refresh-list', (category) => {
                this.getCategories();
            });
        },

        mounted() {
          this.getCategories();
        },

        methods:{

            getCategories(){
                axios.get('/admin/categories')
                    .then(response => {
                        this.categories = response.data;
                    });
            },

            editCategory(category){
              Event.$emit('edit-category', category);
            },

            enableCategory(category){
              category.state = !category.state;
              axios.put('/admin/categories/'+category.id, category)
                  .then(data => {
                    this.notify('Categories management',data.message,'success');
                  })
                  .catch(errors =>{
                    this.notify('Categories management',errors.message,'warn');
                  });
            },

            destroyCategory(category) {
              var self = this;
                this.$dialog.confirm('Need your confirmation to delete serie')
                    .then(function () {
                        axios.delete('/admin/categories/' + category.id)
                            .then(response => {
                                    console.log(response.data);
                                    Event.$emit('refresh-list');
                                    self.notify('Categories management','Category well deleted.','warn');
                                },
                                (err) => {
                                    console.log("Err", err);
                                })
                            .catch(function(err){
                                console.error(err); // This will print any error that was thrown in the previous error handler.
                            });
                    })
            },

            resetForm(){
              Event.$emit('reset-form');
            },

            showModal(){
              this.resetForm();
              $('#modal-form').modal('show');
            },

            notify(title,message,type){
              this.$notify({
                group: 'foo',
                type: type,
                title: title,
                text: message,
                duration: 10000,
                speed: 1000
              });
            }
        }
    }



</script>
