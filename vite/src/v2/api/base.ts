let baseUrl: string
let nonce: string

function initApi(_baseUrl: string, _nonce: string) {
    baseUrl = _baseUrl
    nonce = _nonce
}

export {
    baseUrl,
    initApi,
    nonce,
}
