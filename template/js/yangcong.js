function yangcong_GetResult() {
    Ajax.call(yangcong_post_url, 'event_id='+event_id, yangcong_result_callback, 'POST','JSON');
}

function yangcong_result_callback(result){

    if (result.status >= 0) {

        document.getElementById('return_yangcong_message').innerHTML = result.message;
        
        if (typeof result.url != 'undefined' && result.url != '') {
            location.href = result.url;
        }
    }
}
