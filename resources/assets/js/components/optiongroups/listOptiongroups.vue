<template>
  <div>
      <notifications group="foo" />
      <part-tooltip></part-tooltip>

      <optiongroups-form></optiongroups-form>

      <part-panel>
        <p slot="heading">Option groups List</p>
        <div slot="body">
          <div class="row">
            <div class="col-md-4">
            </div>
              <div class="col-md-3">
                  <button class="btn btn-success btn-block"  @click='showModal()'>
                    <i class="fa fa-plus"></i>
                    &nbsp;&nbsp;ADD NEW OPTION GROUP
                  </button>
              </div>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                  <table class="table table-fixed" id="optiongroupsTable">
                      <thead><tr>
                          <th class="col-xs-1">#ID</th>
                          <th class="col-xs-2">Name</th>
                          <th class="col-xs-2">Description</th>
                          <th class="col-xs-1">Category</th>
                          <th class="col-xs-1">Order</th>
                          <th class="col-xs-2">Date</th>
                          <th class="col-xs-2" style="text-align: center;">action</th>
                      </tr>

                      </thead>
                      <tbody>
                        <tr v-for="optiongroup in optiongroups">
                            <td class="col-xs-1">{{ optiongroup.id }}</td>
                            <td class="col-xs-2"><span class="label bg-gray">{{ optiongroup.name }}</span></td>
                            <td class="col-xs-2">{{ optiongroup.desc }}</td>
                            <td class="col-xs-1"><span class="label bg-green">{{ optiongroup.category.name }}</span></td>
                            <td class="col-xs-1">{{ optiongroup.order }}</td>
                            <td class="col-xs-2">{{ optiongroup.created_at }}</td>
                            <td class="col-xs-2" style="text-align: center;">
                                <button class="btn" @click="editOptionGroup(optiongroup)" data-toggle="tooltip" title="Edit option group"><i class="fa fa-icon fa-edit"></i></button>
                                <!-- <button class="btn" @click="enableGallery(optiongroup)"><i class="fa fa-icon fa-lock"></i></button> -->
                                <button class="btn" @click="destroyOptionGroup(optiongroup)" data-toggle="tooltip" title="Delete option group"><i class="fa fa-icon fa-trash"></i></button>
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
                optiongroups: [],
                dtHandle:'',
            };
        },

        created(){
            Event.$on('refresh-list', (optiongroup) => {
                this.getOptiongroups();
            });
        },

        mounted() {
          this.getOptiongroups();
        },

        methods:{

            getOptiongroups(){
                axios.get('/admin/optiongroups')
                    .then(response => {
                        this.optiongroups = response.data;
                    });
            },

            editOptionGroup(optiongroup){
              Event.$emit('edit-optiongroup', optiongroup);
            },


            destroyOptionGroup(optiongroup) {

                this.$dialog.confirm('Need your confirmation to delete optiongroup')
                    .then(function () {
                        axios.delete('/admin/optiongroups/' + optiongroup.id)
                            .then(response => {
                                    console.log(response.data);
                                    Event.$emit('refresh-list');
                                    this.notify('Option groups management','Gallery well deleted.','warning');
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
