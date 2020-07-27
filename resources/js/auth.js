class Auth {

    constructor() {
        this.token = localStorage.getItem("token");
        this.user = localStorage.getItem("userPB");
        this.userInfo = localStorage.getItem("userInfo");

        if (this.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        }
    }

    login(token, user, userInfo) {
        window.localStorage.setItem('token', token);
        window.localStorage.setItem('userPB', JSON.stringify(user));
        window.localStorage.setItem('userInfo', JSON.stringify(userInfo));

        this.token = token;

        Event.$emit('userLoggedIn');

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    }

    check() {
        return !!this.token;
    }

    logout() {
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('userPB');
        window.localStorage.removeItem('userInfo');
        this.token = false;
        Event.$emit('userLoggedOut');
    }
}

export default Auth;