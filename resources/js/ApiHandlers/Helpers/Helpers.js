export function queryFormatter(params = {}) {
    let query = '?';
    Object.keys(params).forEach(key => {
        if (params[key] != undefined && params[key] != '') {
            if (typeof params[key] != "object") {
                query += key + '=' + (typeof params[key] == "boolean" ? (params[key] ? 1 : 0) : params[key]) + '&';
            } else {
                Object.values(params[key]).forEach(value => {
                    query += key + '[]=' + value + '&';
                });
            }
        }
    });
    return query;
}

export function dataCleanser(params = {}) {
    let cleansedData = {};
    Object.keys(params).forEach(key => {
        if (params[key] != undefined && params[key] != '') {
            cleansedData[key] = (typeof params[key] == "boolean" ? (params[key] ? 1 : 0) : params[key]);
        }
    });
    return cleansedData;

}
