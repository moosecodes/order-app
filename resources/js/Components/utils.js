const likeArticle = async ({article_id, source}) => {
  let response = await axios.put('/api/like', { article_id, source })
  return response.data
}

const saveArticle = async ({article_id, source}) => {
  let response = await axios.put('/api/save', { article_id, source })
  return response.data
}

const track = async ({article_id, api_source}) => {
  let response = await axios.post('/api/viewed', { article_id, api_source })
  return response.data

  // const article = props[api_source].filter(a =>  a.id === response.data.id)
  // article[0].views = response.data.views
}

export { likeArticle, saveArticle, track }
