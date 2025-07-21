
const removeTokenUnAuthorize = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    window.location.href = '/login';
}



export default removeTokenUnAuthorize;
