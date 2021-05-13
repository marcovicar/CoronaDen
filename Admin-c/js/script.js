function ValidarData(data) {
    var splitData = data.split("/");

    var dt = new Date();

    if (splitData.length === 3) {
        if (splitData[0] >= 01 && splitData[0] <= 31) {
            if (splitData[1] >= 01 && splitData[1] <= 12) {
                if (splitData[2] >= (dt.getFullYear() - 100) && splitData[2] <= (dt.getFullYear() - 10)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}