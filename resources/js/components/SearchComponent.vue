<template>
  <div>
    <div class="card-header">Search Plasma</div>
    <form @submit.prevent="searchDonar">
      <div class="form-group">
        <label for="bloodGroup">Blood Group</label>
        <select class="form-control" id="bloodGroup" v-model="searchSingleObj.bloodGroup">
          <option value="A+">A+</option>
          <option value="A-">A-</option>
          <option value="B+">B+</option>
          <option value="B-">B-</option>
          <option value="AB+">AB+</option>
          <option value="AB-">AB-</option>
          <option value="O+">O+</option>
          <option value="O-">O-</option>
        </select>
      </div>
      <div class="form-group">
        <label for="district">District</label>
        <select class="form-control" id="district" v-model="searchSingleObj.district">
          <option value="dhaka">Dhaka</option>
          <option value="Khulna">Khulna</option>
          <option value="Khulna">Rajshahi</option>
          <option value="Khulna">Chittagong</option>
          <option value="sylhet">Sylhet</option>
          <option value="maymanshing">Maymanshing</option>
          <option value="rangpur">Rangpur</option>
          <option value="faridpur">Faridpur</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-block">Search</button>
      </div>
    </form>

    <div v-if="searchResultHas">
      <div
        class="card float-left"
        style="width: 18rem;"
        v-for="single in searchObj"
        :key="single.id"
      >
        <img :src="getImgUrl(single.image)" class="card-img-top" alt="single.blood_group" />
        <div class="card-body">
          <h5 class="card-title">Name: {{single.username}}</h5>
          <h6 class="card-title">Blood Group: {{single.blood_group}}</h6>
          <h6 class="card-title">Phone Number: {{single.phone}}</h6>
          <h6 class="card-title">Email: {{single.email}}</h6>
          <h6 class="card-title">Age: {{single.age}}</h6>
          <h6 class="card-title">Weight: {{single.weight}}</h6>
          <h6 class="card-title">District: {{single.district}}</h6>
          <h6 class="card-title">Test Positive Date: {{single.test_positive_date}}</h6>
          <h6 class="card-title">Test Negative Date: {{single.test_negative_date}}</h6>
          <h6
            class="card-title"
          >Test Negative Date (Second time): {{single.test_negative_date_second}}</h6>
        </div>
      </div>
      <div style="width: 18rem;" v-if="!searchObj.length">
        <h3>Nothing Found</h3>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "search-component",
  data: () => {
    return {
      searchObj: [],
      searchSingleObj: {
        bloodGroup: "",
        district: "",
      },
      searchResultHas: false,
    };
  },
  methods: {
    searchDonar() {
      if (auth.check()) {
        let data = {
          blood_group: this.searchSingleObj.bloodGroup,
          district: this.searchSingleObj.district,
        };

        api.call("post", "api/search-donor", data).then(({ data }) => {
          console.log(data.data);
          this.searchObj = data.data;
          this.searchResultHas = true;
        });
      } else {
        this.$router.push({ name: "login" });
      }
    },
    getImgUrl(pic) {
      //return require("public/storage/images/" + pic);
      //return require(`../public/storage/images/`);
      return `/public/storage/images/${pic}`;
    },
  },
};
</script>
