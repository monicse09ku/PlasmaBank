class Auth {

    constructor() {
        this.token = localStorage.getItem("token");
        this.user = localStorage.getItem("userPB");
        this.userInfo = localStorage.getItem("userInfo");

        if (this.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        }

    }

    login(token, user, userInfo = null) {
        window.localStorage.setItem('token', token);
        window.localStorage.setItem('userPB', JSON.stringify(user));
        if (userInfo != null) {
            window.localStorage.setItem('userInfo', JSON.stringify(userInfo));
            this.userInfo = JSON.stringify(userInfo);
        }

        this.token = token;
        this.user = JSON.stringify(user);

        //Event.$emit('userLoggedIn');

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

        setInterval(() => { this.logout(); window.location.reload(); }, 1800000);
    }

    check() {
        return !!this.token;
    }

    logout() {

        window.localStorage.removeItem('token');
        window.localStorage.removeItem('userPB');
        window.localStorage.removeItem('userInfo');
        this.token = false;
        this.user = null;
        this.userInfo = null;

        //Event.$emit('userLoggedOut');
    }

    setUserInfo(userInfo = null, user = null) {
        if (userInfo != null) {
            window.localStorage.removeItem('userInfo');
            window.localStorage.setItem('userInfo', JSON.stringify(userInfo));
            this.userInfo = JSON.stringify(userInfo);
        }
        if (user != null) {
            window.localStorage.removeItem('userPB');
            window.localStorage.setItem('userPB', JSON.stringify(user));
            this.user = JSON.stringify(user);
        }
    }
}

export default Auth;