const searchNews = (searchQuery) => {
    axios.post('/api/news/search', {
        searchQuery
    }).then(res => {
        console.log(res);
    })
}

export { searchNews }
