function validateForm() {
    // validating first name
    const fName = document.getElementById("fname").value;
    if (!fName) {
        updateInnerHtml("err-fname", "First name is required.");
        return false;
    } else {
        updateInnerHtml("err-fname", "");
    }

    // validating last name
    const lName = document.getElementById("lname").value;
    if (!lName) {
        updateInnerHtml("err-lname", "Last name is required.");
        return false;
    } else {
        updateInnerHtml("err-lname", "");
    }

    // validate linkedin url
    const linkedinUrl = document.getElementById("linkedin").value;
    if (linkedinUrl && !validateLink(linkedinUrl)) {
        updateInnerHtml("err-linkedin", "Please enter a valid link.");
        return false;
    } else {
        updateInnerHtml("err-linkedin", "");
    }

    // validating email
    const email = document.getElementById("email").value;
    const mailingList = document.getElementById("mailing-list").checked;

    if (mailingList && !email) {
        updateInnerHtml("err-email", "Email address is required for mailing list.");
        return false;
    } else {
        updateInnerHtml("err-email", "");
    }

    if (email && !validateEmail(email)) {
        updateInnerHtml("err-email", "Please enter a valid email address.");
        return false;
    } else {
        updateInnerHtml("err-email", "");
    }

    const meetingType = document.getElementById("mtype").value;
    const other = document.getElementById("other").value;
    console.log({
        fName,
        lName,
        email,
        other,
        meetingType,
        linkedinUrl,
        mailingList,
    });
    if (!meetingType) {
        updateInnerHtml("err-mtype", "How we met is required.");
        return false;
    } else {
        updateInnerHtml("err-mtype", "");
        if (meetingType === "other" && !other) {
            updateInnerHtml("err-other", "Please specify how you met.");
            return false;
        } else {
            updateInnerHtml("err-other", "");
        }
    }
}

function updateInnerHtml(id, text) {
    document.getElementById(id).innerHTML = text;
}

function validateEmail(email) {
    return String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
}

function validateLink(url) {
    const lowerCaseUrl = String(url).toLowerCase();
    return lowerCaseUrl.startsWith("http") && lowerCaseUrl.endsWith(".com");
}

function showOther(value) {
    console.log(value);
    if (value === "other") {
        document.getElementById("other-type").classList.remove("hide");
    } else {
        document.getElementById("other-type").classList.add("hide");
    }
}

function showMailingListType(value) {
    if (value) {
        document.getElementById("mailing-list-type").classList.remove("hide");
    } else {
        document.getElementById("mailing-list-type").classList.add("hide");
    }
}
