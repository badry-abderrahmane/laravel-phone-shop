<template>
  <div>
      <div class="nav-tabs-custom">
            <product-color-form :id="id"></product-color-form><br><br>
            <table class="table">
              <tbody>
                <tr v-for="color in colors">
                  <td><b>{{ color.name }}</b></td>
                  <td><font v-bind:background-color="color.color.code">{{ color.color.name }}</font></td>
                  <td>
                    <div v-bind:style="{ width: '30px', height: '30px', backgroundColor: color.color.code}"></div>
                  </td>
                  <td>
                    <button class="btn" @click="editProduct(product)"><i class="fa fa-icon fa-edit"></i></button>
                    <button class="btn" @click="destroyProduct(product)"><i class="fa fa-icon fa-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
      </div>
  </div>
</template>

<script>
  export default{
    props: ['productcolors','id'],


    data(){
      return{
        colors : JSON.parse(this.productcolors)
      }
    },
    created(){
      Event.$on('refresh-productcolors-list', () => {
        this.form.reset();
      });
    }
  }


</script>
