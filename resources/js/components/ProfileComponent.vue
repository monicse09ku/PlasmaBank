<template>
  <div>
    <div class="container bootstrap snippet">
      <div class="row">
        <div class="col-sm-10">
          <h1>{{data.name}}</h1>
        </div>
        <div class="col-sm-2"></div>
      </div>
      <br />
      <form @submit.prevent="update" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-3">
            <!--left col-->

            <div class="text-center">
              <img
                v-if="data.image==''"
                src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png"
                class="avatar img-circle img-thumbnail"
                alt="avatar"
              />
              <img
                v-else
                :src="getImgUrl(data.image)"
                class="avatar img-circle img-thumbnail"
                alt="avatar"
              />
              <h6>Upload a different photo...</h6>
              <input
                type="file"
                class="text-center center-block file-upload"
                @change="selectAvatar"
              />
            </div>
            <hr />
            <br />
          </div>
          <div class="col-sm-9 row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="name">Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  placeholder="Enter your name please"
                  required
                  v-model="data.name"
                />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="email">Email address</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  placeholder="Enter email"
                  required
                  v-model="data.email"
                />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="phone">Phone</label>
                <input
                  type="phone"
                  class="form-control"
                  id="phone"
                  placeholder="Enter phone number please"
                  aria-describedby="phonelHelp"
                  required
                  v-model="data.phone"
                />
                <small
                  id="phonelHelp"
                  class="form-text text-muted"
                >Please add your country code please. Like Bangladesh +8801711111111. Phone number need for login.</small>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="sex">Sex</label>
                <select class="form-control" id="sex" required v-model="data.sex">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
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
                  v-model="data.age"
                />
              </div>
            </div>
            <div class="col-sm-6">
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
                  v-model="data.weight"
                />
                <small
                  id="weightHelp"
                  class="form-text text-muted"
                >Please enter your weight in kg format.</small>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="district">District</label>
                <select class="form-control" id="district" v-model="data.district" required>
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
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="blood_group">Blood Group</label>
                <select class="form-control" id="blood_group" v-model="data.blood_group" required>
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
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="test_positive_date">Test Positive Date</label>
                <input
                  class="form-control"
                  type="date"
                  id="test_positive_date"
                  v-model="data.test_positive_date"
                  required
                />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="test_negative_date">Test Negative Date</label>
                <input
                  class="form-control"
                  type="date"
                  id="test_negative_date"
                  v-model="data.test_negative_date"
                />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="test_negative_date_second">Test Negative Date (Second Time)</label>
                <input
                  class="form-control"
                  type="date"
                  id="test_negative_date_second"
                  v-model="data.test_negative_date_second"
                />
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <br />
                <button type="submit" class="btn btn-lg btn-success">
                  <i class="glyphicon glyphicon-ok-sign"></i> Update
                </button>
              </div>
            </div>
          </div>
          <!--/col-9-->
        </div>
      </form>
      <!--/row-->
    </div>
  </div>
</template>
<script>
export default {
  name: "profile-component",
  data: () => {
    return {
      data: {
        name: "",
        email: "",
        phone: "",
        sex: "",
        image: "",
        age: "",
        weight: "",
        blood_group: "",
        district: "",
        test_positive_date: "",
        test_negative_date: "",
        test_negative_date_second: "",
        user_id: "",
      },
      updateAvatar: "",
      test: "",
    };
  },
  created() {
    this.updateLocalUserInfos();
  },

  methods: {
    getImgUrl(pic) {
      return `/public/storage/images/${pic}`;
    },
    selectAvatar(event) {
      this.updateAvatar = event.target.files[0];
    },
    update() {
      let data = new FormData();
      data.append("user_id", this.data.user_id);
      data.append("image", this.updateAvatar);
      data.append("sex", this.data.sex);
      data.append("phone", this.data.phone);
      data.append("email", this.data.email);
      data.append("username", this.data.name);
      data.append("age", this.data.age);
      data.append("weight", this.data.weight);
      data.append("blood_group", this.data.blood_group);
      data.append("district", this.data.district);
      data.append("test_positive_date", this.data.test_positive_date);
      data.append("test_negative_date", this.data.test_negative_date);
      data.append(
        "test_negative_date_second",
        this.data.test_negative_date_second
      );

      api.call("post", "api/update", data).then(({ data }) => {
        if (data == 1) alert("Nothing Changed");
        else {
          auth.setUserInfo(data.data, data.user);
          this.updateLocalUserInfos();
          alert("Update Successful");
        }
      });
    },
    updateLocalUserInfos() {
      let user = JSON.parse(auth.user);
      let userInfo = JSON.parse(auth.userInfo);
      let result = { ...user, ...userInfo };
      this.data.name = result.username;
      this.data.email = result.email;
      this.data.phone = result.phone;
      this.data.sex = result.sex;
      this.data.image = result.image;
      this.data.age = result.age;
      this.data.weight = result.weight;
      this.data.blood_group = result.blood_group;
      this.data.district = result.district;
      this.data.test_positive_date = result.test_positive_date;
      this.data.test_negative_date = result.test_negative_date;
      this.data.test_negative_date_second = result.test_negative_date_second;
      this.data.user_id = result.user_id;
    },
  },
  computed: {
    computerExample: function () {
      return this.test + "ok";
    },
  },
};
</script>