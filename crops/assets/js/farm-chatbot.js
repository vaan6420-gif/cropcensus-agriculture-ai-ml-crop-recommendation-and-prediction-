(function () {
  "use strict";

  var tools = {
    cropRecommendation: {
      label: "Crop recommendation",
      category: "recommendation",
      page: "crop_recommendation.php",
      submit: ["Crop_Recommend", "Recommend"],
      resultLabel: "Recommended crop",
      fields: [
        { name: "n", label: "Nitrogen (N)", example: "e.g. 90" },
        { name: "p", label: "Phosphorus (P)", example: "e.g. 42" },
        { name: "k", label: "Potassium (K)", example: "e.g. 43" },
        { name: "t", label: "Temperature (°C)", example: "e.g. 21" },
        { name: "h", label: "Humidity (%)", example: "e.g. 82" },
        { name: "ph", label: "Soil pH", example: "e.g. 6.5" },
        { name: "r", label: "Rainfall (mm)", example: "e.g. 203" }
      ]
    },
    fertilizerRecommendation: {
      label: "Fertilizer recommendation",
      category: "recommendation",
      page: "fertilizer_recommendation.php",
      submit: ["Fert_Recommend", "Recommend"],
      resultLabel: "Recommended fertilizer",
      fields: [
        { name: "n", label: "Nitrogen (N)", example: "e.g. 37" },
        { name: "p", label: "Phosphorus (P)", example: "e.g. 0" },
        { name: "k", label: "Potassium (K)", example: "e.g. 0" },
        { name: "t", label: "Temperature (°C)", example: "e.g. 26" },
        { name: "h", label: "Humidity (%)", example: "e.g. 52" },
        { name: "soilMoisture", label: "Soil moisture", example: "e.g. 38" },
        {
          name: "soil",
          label: "Soil type",
          options: ["Sandy", "Loamy", "Black", "Red", "Clayey"]
        },
        {
          name: "crop",
          label: "Crop",
          options: ["Maize", "Sugarcane", "Cotton", "Tobacco", "Paddy", "Barley", "Wheat", "Millets", "Oil seeds", "Pulses", "Ground Nuts"]
        }
      ]
    },
    cropPrediction: {
      label: "Crop prediction by location",
      category: "prediction",
      page: "crop_prediction.php",
      submit: ["Crop_Predict", "Predict"],
      resultLabel: "Crop prediction",
      fields: [
        { name: "stt", label: "State", optionsFrom: "states" },
        { name: "district", label: "District", optionsFrom: "cropPredictionDistricts" },
        {
          name: "Season",
          label: "Growing season",
          options: ["Kharif", "Whole Year", "Autumn", "Rabi", "Summer", "Winter"]
        }
      ]
    },
    yieldPrediction: {
      label: "Yield prediction",
      category: "prediction",
      page: "yield_prediction.php",
      submit: ["Yield_Predict", "Yield"],
      resultLabel: "Estimated crop production",
      fields: [
        { name: "state", label: "State", options: ["Karnataka"] },
        { name: "district", label: "District", optionsFrom: "yieldDistricts" },
        {
          name: "Season",
          label: "Growing season",
          options: ["Kharif", "Rabi", "Summer", "WholeYear"]
        },
        { name: "crops", label: "Crop", optionsFrom: "yieldCrops" },
        { name: "area", label: "Cultivated area (hectares)", example: "e.g. 2.5" }
      ]
    },
    rainfallPrediction: {
      label: "Rainfall prediction",
      category: "prediction",
      page: "rainfall_prediction.php",
      submit: ["Rainfall_Predict", "Yield"],
      resultLabel: "Estimated average rainfall",
      fields: [
        { name: "region", label: "Region", optionsFrom: "rainfallRegions" },
        { name: "month", label: "Month or period", optionsFrom: "rainfallMonths" }
      ]
    }
  };

  var root = document.getElementById("farm-chat");
  if (!root) {
    return;
  }

  var launcher = document.getElementById("farm-chat-launcher");
  var closeButton = document.getElementById("farm-chat-close");
  var panel = document.getElementById("farm-chat-panel");
  var messages = document.getElementById("farm-chat-messages");
  var controls = document.getElementById("farm-chat-controls");
  var conversation = { tool: null, fieldIndex: 0, answers: {} };

  function appendMessage(text, sender) {
    var message = document.createElement("div");
    message.className = "farm-chat-message farm-chat-message-" + sender;
    message.textContent = text;
    messages.appendChild(message);
    messages.scrollTop = messages.scrollHeight;
  }

  function clearControls() {
    controls.replaceChildren();
  }

  function setOpen(isOpen) {
    root.classList.toggle("farm-chat-open", isOpen);
    launcher.setAttribute("aria-expanded", String(isOpen));
    panel.setAttribute("aria-hidden", String(!isOpen));
    if (isOpen) {
      if (messages.childElementCount === 0) {
        startConversation();
      }
      closeButton.focus();
    } else {
      launcher.focus();
    }
  }

  function addChoice(label, value, callback) {
    var button = document.createElement("button");
    button.type = "button";
    button.className = "farm-chat-choice";
    button.textContent = label;
    button.addEventListener("click", function () {
      appendMessage(label, "user");
      clearControls();
      callback(value);
    });
    controls.appendChild(button);
  }

  function startConversation() {
    conversation = { tool: null, fieldIndex: 0, answers: {} };
    appendMessage("Welcome to Crop Census! I’m glad you’re here.", "bot");
    window.setTimeout(function () {
      var userName = root.getAttribute("data-user-name");
      var greeting = userName
        ? "Hi, " + userName + "! I’m your farm assistant. Would you like a recommendation or a prediction?"
        : "Hi there! I’m your farm assistant. Sign in to use the tools, or choose what you’d like help with.";
      appendMessage(greeting, "bot");
      addChoice("Recommendation", "recommendation", chooseCategory);
      addChoice("Prediction", "prediction", chooseCategory);
    }, 450);
  }

  function chooseCategory(category) {
    appendMessage("Choose a " + category + " tool:", "bot");
    Object.keys(tools).forEach(function (key) {
      if (tools[key].category === category) {
        addChoice(tools[key].label, key, chooseTool);
      }
    });
    addChoice("Start over", "start", startConversation);
  }

  function chooseTool(key) {
    var selectedTool = tools[key];
    conversation = { tool: selectedTool, fieldIndex: 0, answers: {} };
    if (root.getAttribute("data-authenticated") !== "true") {
      showAuthenticationRequired(selectedTool);
      return;
    }
    appendMessage("I’ll ask a few details for " + conversation.tool.label + ".", "bot");
    askNextField();
  }

  function showAuthenticationRequired(tool) {
    appendMessage(
      "Please sign in or create an account before using " + tool.label.toLowerCase() +
      ". You can sign in or register right here, and I’ll continue helping you in this chat.",
      "bot"
    );
    addAuthenticationLinks(tool);
  }

  function addAuthenticationLinks(tool) {
    clearControls();
    addChoice("Sign in", "login", function () {
      showAuthenticationForm(tool, "login");
    });
    addChoice("Create account", "register", function () {
      showAuthenticationForm(tool, "register");
    });
    addChoice("Choose another tool", "start", startConversation);
  }

  function showAuthenticationForm(tool, mode) {
    var isRegistration = mode === "register";
    appendMessage(
      isRegistration
        ? "Create your Crop Census account here. You can sign in below after registration."
        : "Enter your Crop Census sign-in details here.",
      "bot"
    );
    clearControls();

    var form = document.createElement("form");
    form.className = "farm-chat-auth-form";
    form.setAttribute("aria-label", isRegistration ? "Create account" : "Sign in");

    if (isRegistration) {
      addAuthField(form, "name", "Full name", "text", true, "name");
    }
    addAuthField(form, "email", "Email address", "email", true, "email");
    addAuthField(form, "password", "Password", "password", true, isRegistration ? "new-password" : "current-password");
    if (isRegistration) {
      addAuthField(form, "confirm_password", "Confirm password", "password", true, "new-password");
    }

    var hiddenRedirect = document.createElement("input");
    hiddenRedirect.type = "hidden";
    hiddenRedirect.name = "redirect";
    hiddenRedirect.value = tool.page;
    form.appendChild(hiddenRedirect);

    var submit = document.createElement("button");
    submit.type = "submit";
    submit.className = "farm-chat-send";
    submit.textContent = isRegistration ? "Create account" : "Sign in";
    form.appendChild(submit);

    form.addEventListener("submit", function (event) {
      event.preventDefault();
      submit.disabled = true;
      submit.textContent = "Please wait…";

      fetch(isRegistration ? "register.php" : "login.php", {
        method: "POST",
        credentials: "same-origin",
        headers: { "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8" },
        body: new URLSearchParams(new FormData(form)).toString()
      }).then(function (response) {
        if (!response.ok) {
          throw new Error("The account page returned an HTTP " + response.status + " response.");
        }
        return response.text().then(function (html) {
          return { html: html };
        });
      }).then(function (result) {
        var authDocument = new DOMParser().parseFromString(result.html, "text/html");
        var successAlert = authDocument.querySelector(".alert-success");
        var errorAlert = authDocument.querySelector(".alert-danger");
        var accountWidget = authDocument.querySelector("#farm-chat");
        var isAuthenticated = accountWidget &&
          accountWidget.getAttribute("data-authenticated") === "true";

        if (isAuthenticated) {
          root.setAttribute("data-authenticated", "true");
          var userName = accountWidget.getAttribute("data-user-name");
          if (userName) {
            root.setAttribute("data-user-name", userName);
          }
          clearControls();
          appendMessage(
            (userName ? "You’re signed in, " + userName + ". " : "You’re signed in. ") +
            "Let’s continue with " + tool.label.toLowerCase() + ".",
            "bot"
          );
          conversation = { tool: tool, fieldIndex: 0, answers: {} };
          askNextField();
          return;
        }

        if (isRegistration && successAlert) {
          appendMessage(successAlert.textContent.trim(), "bot");
          showAuthenticationForm(tool, "login");
          return;
        }

        if (errorAlert) {
          appendMessage(errorAlert.textContent.trim(), "bot");
          showAuthenticationForm(tool, mode);
          return;
        }

        throw new Error("The account action did not complete. Please try again.");
      }).catch(function (error) {
        appendMessage(error.message || "Sorry, the account request could not be completed.", "bot");
        showAuthenticationForm(tool, mode);
      });

    });

    controls.appendChild(form);
    addChoice(
      isRegistration ? "Already have an account? Sign in" : "Need an account? Create one",
      isRegistration ? "login" : "register",
      function (nextMode) {
        showAuthenticationForm(tool, nextMode);
      }
    );
    addChoice("Choose another tool", "start", startConversation);
    form.querySelector("input:not([type='hidden'])").focus();
  }

  function addAuthField(form, name, labelText, type, required, autocomplete) {
    var label = document.createElement("label");
    label.className = "farm-chat-auth-label";
    label.textContent = labelText;

    var input = document.createElement("input");
    input.className = "farm-chat-input";
    input.name = name;
    input.type = type;
    input.required = required;
    input.autocomplete = autocomplete;
    if (name === "password" && type === "password") {
      input.minLength = 8;
    }
    if (name === "confirm_password") {
      input.minLength = 8;
    }

    label.appendChild(input);
    form.appendChild(label);
  }

  function getOptions(field) {
    var stateIndex;
    var districts;
    if (field.options) {
      return field.options;
    }

    switch (field.optionsFrom) {
      case "states":
        return window.state_arr || [];
      case "cropPredictionDistricts":
        stateIndex = (window.state_arr || []).indexOf(conversation.answers.stt);
        districts = stateIndex >= 0 && window.s_a ? window.s_a[stateIndex + 1] : "";
        return districts ? districts.split("|").map(function (value) {
          return value.trim();
        }).filter(Boolean) : [];
      case "yieldDistricts":
        return typeof cropOptions !== "undefined" ? Object.keys(cropOptions) : [];
      case "yieldCrops":
        return typeof cropOptions !== "undefined" &&
          cropOptions[conversation.answers.district] &&
          cropOptions[conversation.answers.district][conversation.answers.Season] || [];
      case "rainfallRegions":
        return window.region || [];
      case "rainfallMonths":
        return window.months || [];
      default:
        return [];
    }
  }

  function askNextField() {
    var field = conversation.tool.fields[conversation.fieldIndex];
    if (!field) {
      submitToolRequest();
      return;
    }

    appendMessage("What is the " + field.label + "?", "bot");
    if (field.options || field.optionsFrom) {
      askWithSelect(field);
      return;
    }
    askWithInput(field);
  }

  function saveAnswer(field, value) {
    conversation.answers[field.name] = value;
    conversation.fieldIndex += 1;
    askNextField();
  }

  function askWithSelect(field) {
    var form = document.createElement("form");
    form.className = "farm-chat-answer-form";
    var select = document.createElement("select");
    select.className = "farm-chat-select";
    select.required = true;
    var placeholder = document.createElement("option");
    placeholder.value = "";
    placeholder.textContent = "Select " + field.label.toLowerCase();
    select.appendChild(placeholder);

    getOptions(field).forEach(function (value) {
      var option = document.createElement("option");
      option.value = value;
      option.textContent = value;
      select.appendChild(option);
    });

    if (select.options.length === 1) {
      appendMessage("I could not load the choices for that field. Please reload the page and try again.", "bot");
      addRestartChoice();
      return;
    }

    var submit = document.createElement("button");
    submit.type = "submit";
    submit.className = "farm-chat-send";
    submit.textContent = "Continue";
    form.appendChild(select);
    form.appendChild(submit);
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      if (!select.value) {
        select.focus();
        return;
      }
      appendMessage(select.value, "user");
      clearControls();
      saveAnswer(field, select.value);
    });
    controls.appendChild(form);
    select.focus();
  }

  function askWithInput(field) {
    var form = document.createElement("form");
    form.className = "farm-chat-answer-form";
    var input = document.createElement("input");
    input.className = "farm-chat-input";
    input.type = "number";
    input.step = "any";
    input.required = true;
    input.inputMode = "decimal";
    input.placeholder = field.example;
    input.setAttribute("aria-label", field.label);

    var submit = document.createElement("button");
    submit.type = "submit";
    submit.className = "farm-chat-send";
    submit.textContent = "Send";
    form.appendChild(input);
    form.appendChild(submit);
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      if (!input.value || !Number.isFinite(Number(input.value))) {
        input.focus();
        return;
      }
      appendMessage(input.value, "user");
      clearControls();
      saveAnswer(field, input.value);
    });
    controls.appendChild(form);
    input.focus();
  }

  function addRestartChoice() {
    addChoice("Start over", "start", startConversation);
  }

  function submitToolRequest() {
    var tool = conversation.tool;
    appendMessage("Thanks. I’m checking that with the " + tool.label.toLowerCase() + " tool now.", "bot");
    var status = document.createElement("div");
    status.className = "farm-chat-loading";
    status.textContent = "Please wait while the result is prepared…";
    controls.appendChild(status);

    var body = new URLSearchParams();
    Object.keys(conversation.answers).forEach(function (name) {
      body.append(name, conversation.answers[name]);
    });
    body.append(tool.submit[0], tool.submit[1]);

    fetch(tool.page, {
      method: "POST",
      credentials: "same-origin",
      headers: { "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8" },
      body: body.toString()
    }).then(function (response) {
      if (!response.ok) {
        throw new Error("The tool returned an HTTP " + response.status + " response.");
      }
      if (new URL(response.url).pathname.endsWith("/login.php")) {
        showAuthenticationRequired(tool);
        return null;
      }
      return response.text();
    }).then(function (html) {
      if (html === null) {
        return;
      }
      if (!html) {
        throw new Error("The tool did not return a result.");
      }
      var resultDocument = new DOMParser().parseFromString(html, "text/html");
      var result = resultDocument.querySelector(".card h4");
      if (!result || !result.textContent.trim()) {
        throw new Error("I couldn’t read a result. Please check the inputs and try again.");
      }
      appendMessage(tool.resultLabel + ": " + result.textContent.trim(), "bot");
      clearControls();
      addChoice("Ask another question", "start", startConversation);
    }).catch(function (error) {
      clearControls();
      appendMessage(error.message || "Sorry, I couldn’t complete that request. Please try the tool page directly.", "bot");
      addRestartChoice();
    });
  }

  launcher.addEventListener("click", function () {
    setOpen(!root.classList.contains("farm-chat-open"));
  });
  closeButton.addEventListener("click", function () {
    setOpen(false);
  });
})();
