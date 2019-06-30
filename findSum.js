const getAllNumbers = (n) => {
    const arr = [];
    if(n==0){
        return arr;
    }{
        arr.push(n);
        arr.push(...getAllNumbers(n-1));  
    }
    return arr;
}

const lengthSet = (n)=>{
    return n.length;
};

const subset = (n) => {
    const set = getAllNumbers(n);
    const length = lengthSet(set);
    if(length==0 || n<0){
        return 0;
    }

    let arr = {};
    for(i=0;i<length;i++){
        arr[i] = {0: true};
    }

    for(i=1;i<=n;i++){
        arr[0][i] = false;
    }


    for(i=1;i<length;i++){
        for(j=0; j <= n; j++){
            if(j<=set[i-1]){
                // console.log(arr[i-1][j]);
                arr[i][j] = arr[i-1][j] ? true : false;
            }
            if(j>=set[i-1]){
                arr[i][j] = arr[i-1][j] || arr[i-1][j-set[i-1]] ? true : false;
            }
        }
    }
    if(arr[length-1][n]==false){
        console.log('none');
    }
    const new_set = [];
    printSubset(arr, n-1, n, new_set, set);
};

const printSubset = (arr, i, n, set, ori_set) => {
    if(n == 0){
        console.log(set);
    }

    if(i<=0 || n<0){
        return false;
    }
    if(arr[i-1][n]){
        printSubset(arr,i-1,n,set, ori_set);
    }
    if(n>=ori_set[i-1] && arr[i-1][n-ori_set[i-1]]){
        set.push(ori_set[i-1]);       
        printSubset(arr,i-1,n-ori_set[i-1],set, ori_set);
        set.pop();
    }
};

console.log(subset(10));