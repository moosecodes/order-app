const likeArticle = ({article_id, source}) => {
  axios.put('/api/like', { article_id, source })
    .then(function (response) {
      console.log(article_id)
      console.log(source)
      console.log(response.data)
      // article.value = props.articles[api_source].filter(a =>  a.id === response.data.id)
      // article.value[0].favs = response.data.favs
      // console.log(article.value)

    })
    .catch(function (error) {
      console.log(error)
    })
}
const saveArticle = ({article_id, source}) => {
  axios.put('/api/save', { article_id, source })
    .then(function (response) {
      console.log(response.data)
      console.log(source)
      console.log(article_id)
      // const article = props.articles[source].filter(a =>  a.id === response.data.id)
      // article[0].favs = response.data.favs
    })
    .catch(function (error) {
      console.log(error)
    })
}

const track = ({article_id, api_source, props}) => {
  axios.post('/api/viewed', { article_id, api_source })
    .then(function (response) {
      const article = props[api_source].filter(a =>  a.id === response.data.id)
      article[0].views = response.data.views
    })
    .catch(function (error) {
      console.log(error)
    })
}

export { likeArticle, saveArticle, track }
