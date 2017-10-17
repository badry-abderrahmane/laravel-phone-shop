<template>
  <div>
      <notifications group="productoptions" />
      <product-option-form :productid="productid"></product-option-form><br><br>
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li v-bind:class="{ active: key == 0 }" v-for="(productoption,optiongroup,key) in productoptions">
            <a data-toggle="tab" aria-expanded="true" v-bind:href="'#'+optiongroup">{{ optiongroup }}</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane" v-bind:id="optiongroup" v-bind:class="{ active: key == 0 }" v-for="(productoption,optiongroup,key) in productoptions">
            <table class="table">

              <tbody>
                <tr v-for="option in productoption">
                  <td><b>{{ option.name }}</b></td>
                  <td>{{ option.value }}</td>
                  <td>
                    <button class="btn" @click="editProductOption(option)"><i class="fa fa-icon fa-edit"></i></button>
                    <button class="btn" @click="destroyProductOption(option)"><i class="fa fa-icon fa-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
  export default{
    props: ['productid'],

    data(){
      return{
        productoptions : {}
      }
    },

    created(){
      this.getProductOptions();
      Event.$on('refresh-productoptions-list', () => {
        this.getProductOptions();
      });
    },

    methods:{
      getProductOptions(){
        let optionLabels = {};
        axios.get('/admin/productoptions/'+this.productid+'/edit')
            .then(response => {
                this.productoptions = response.data;
                console.log(this.productoptions);
                this.productoptions.map(function(value,key){
                  console.log(value.option.optiongroup.name);
                  optionLabels[value.option.optiongroup.name] = {};
                });
                this.productoptions.map(function(value,key){
                  optionLabels[value.option.optiongroup.name][key] = {};
                  optionLabels[value.option.optiongroup.name][key]['id'] = value.id;
                  optionLabels[value.option.optiongroup.name][key]['name'] = value.option.name;
                  optionLabels[value.option.optiongroup.name][key]['value'] = value.value
                  optionLabels[value.option.optiongroup.name][key]['option_id'] = value.option_id;
                });
                this.productoptions = optionLabels;
            });
      },

      editProductOption(productoption){
        Event.$emit('edit-product-option', productoption);
      },

      notify(title,message,type){
        this.$notify({
          group: 'productoptions',
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
