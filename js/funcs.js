function post_to_url(path, params, method)
{
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
	
}

function h1(page_,title_)
{
	post_to_url("",{page:page_,title:title_});
}

function linkhl(x)
{
	x.style.color = "#FFFFFF";
	x.style.background = "#0000FF";
}
function linkunhl(x)
{
	x.style.color = "#0000FF";
	x.style.background = "#FFFFFF";
}
