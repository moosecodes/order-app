const searchNews = (searchQuery) => {
    axios.post('/api/news/search', {
        searchQuery
    }).then(res => {
        console.log(res);
    })
}

const likeArticle = async (id) => {
    axios.put('/api/news/like', { id })
        .then(function (response) {
            return response.data.favs
        })
        .catch(function (error) {
            console.log(error);
        });
}

export { searchNews, likeArticle }
