<template>
  <div>
    <div class="card-header">User Information</div>
    <form @submit.prevent="userinformation">
      <div class="form-group">
        <label for="age">Age</label>
        <input
          type="number"
          class="form-control"
          id="age"
          min="18"
          max="65"
          placeholder="Enter your age please"
          required
          v-model="age"
        />
      </div>
      <div class="form-group">
        <label for="weight">Weight</label>
        <input
          type="number"
          class="form-control"
          id="weight"
          placeholder="Enter your weight"
          min="30"
          max="100"
          aria-describedby="weightHelp"
          required
          v-model="weight"
        />
        <small id="weightHelp" class="form-text text-muted">Please enter your weight in kg format.</small>
      </div>
      <div class="form-group">
        <label for="district">District</label>
        <select class="form-control" id="district" v-model="district" required>
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
        <label for="blood_group">Blood Group</label>
        <select class="form-control" id="blood_group" v-model="blood_group" required>
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
        <label for="test_positive_date">Test Positive Date</label>
        <input
          class="form-control"
          type="date"
          id="test_positive_date"
          v-model="test_positive_date"
          required
        />
      </div>
      <div class="form-group">
        <label for="test_negative_date">Test Negative Date</label>
        <input
          class="form-control"
          type="date"
          id="test_negative_date"
          v-model="test_negative_date"
        />
      </div>
      <div class="form-group">
        <label for="test_negative_date_second">Test Negative Date (Second Time)</label>
        <input
          class="form-control"
          type="date"
          id="test_negative_date_second"
          v-model="test_negative_date_second"
        />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>
<script>
export default {
  name: "userinfo-component",
  data: () => {
    return {
      age: "",
      weight: "",
      blood_group: "",
      district: "",
      test_positive_date: "",
      test_negative_date: "",
      test_negative_date_second: "",
      user_id: "",
    };
  },
  created() {
    this.user_id = this.$route.params.user_id;
  },
  methods: {
    userinformation() {
      let data = {
        user_id: this.user_id,
        age: this.age,
        weight: this.weight,
        blood_group: this.blood_group,
        district: this.district,
        test_positive_date: this.test_positive_date,
        test_negative_date: this.test_negative_date,
        test_negative_date_second: this.test_negative_date_second,
      };
      api.call("post", "api/complete-registration", data).then(({ data }) => {
        auth.setUserInfo(data.userInfo);
        this.$router.push({
          name: "search",
        });
      });
    },
  },
};
</script>