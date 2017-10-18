<template>
  <div>
      <notifications group="foo" />
      <part-tooltip></part-tooltip>

      <options-form></options-form>

      <part-panel>
        <p slot="heading">Series List</p>
        <div slot="body">
          <div class="row">
            <div class="col-md-4">
            </div>
              <div class="col-md-3">
                  <button class="btn btn-success btn-block" @click='showModal()'>
                    <i class="fa fa-plus"></i>
                    &nbsp;&nbsp;ADD NEW OPTION
                  </button>
              </div>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                  <table class="table table-fixed" id="optionsTable">
                      <thead><tr>
                          <th class="col-xs-1">#ID</th>
                          <th class="col-xs-2">Name</th>
                          <th class="col-xs-1">Option group</th>
                          <th class="col-xs-2">Description</th>
                          <th class="col-xs-2">Date</th>
                          <th class="col-xs-2" style="text-align: center;">action</th>
                      </tr>

                      </thead>
                      <tbody>
                        <tr v-for="option in options">
                            <td class="col-xs-1">{{ option.id }}</td>
                            <td class="col-xs-2"><span class="label bg-gray">{{ option.name }}</span></td>
                            <td class="col-xs-1"><span class="label bg-green">{{ option.optiongroup.name }}</span></td>
                            <td class="col-xs-2">{{ option.desc }}</td>
                            <td class="col-xs-2">{{ option.created_at }}</td>
                            <td class="col-xs-2" style="text-align: center;">
                                <button class="btn" @click="editOption(option)" data-toggle="tooltip" title="Edit option"><i class="fa fa-icon fa-edit"></i></button>
                                <!-- <button class="btn" @click="enableOption(option)"><i class="fa fa-icon fa-lock"></i></button> -->
                                <button class="btn" @click="destroyOption(option)" data-toggle="tooltip" title="Delete option"><i class="fa fa-icon fa-trash"></i></button>
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
                options: [],
                dtHandle:'',
            };
        },

        created(){
            Event.$on('refresh-list', (option) => {
                this.getOptions();
            });
        },

        mounted() {
          this.getOptions();
        },

        methods:{

            getOptions(){
                axios.get('/admin/options')
                    .then(response => {
                        this.options = response.data;
                    });
            },

            editOption(option){
              Event.$emit('edit-option', option);
            },

            enableOption(option){
              option.state = !option.state;
              axios.put('/admin/options/'+option.id, option)
                  .then(data => {
                    this.notify('Options management',data.message,'success');
                  })
                  .catch(errors =>{
                    this.notify('Options management',errors.message,'warn');
                  });
            },

            destroyOption(option) {

                this.$dialog.confirm('Need your confirmation to delete option')
                    .then(function () {
                        axios.delete('/admin/options/' + option.id)
                            .then(response => {
                                    console.log(response.data);
                                    Event.$emit('refresh-list');
                                    this.notify('Options management','Option well deleted.','warning');
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
