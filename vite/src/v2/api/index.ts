import {baseUrl as _baseUrl, initApi as _initApi, nonce as _nonce} from '@/v2/api/base'
import _V1 from '@/v2/api/v1'

namespace Api {
    export const initApi = _initApi
    export const baseUrl = _baseUrl
    export const nonce = _nonce

    export import V1 = _V1
}

export default Api
