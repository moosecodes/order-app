const searchNews = (searchQuery) => {
    axios.post('/api/news/search', {
        searchQuery
    }).then(res => {
        console.log(res);
    })
}

const likeArticle = (id) => {
    axios.put('/api/news/like', {
        id: id
    })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });
}

export { searchNews, likeArticle }
