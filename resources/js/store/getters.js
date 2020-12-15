const getters = {
    guest: state => state.user.guest,
    username: state => state.user.username,
    avatar:state => state.user.avatar,
    profile: state => state.user.profile,
};

export default getters
