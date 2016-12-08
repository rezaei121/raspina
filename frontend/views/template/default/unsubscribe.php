{{ use('yii/widgets/ActiveForm') }}
{{ use('yii/captcha/Captcha') }}
{% set contact_message = app.session.getFlash('contact-message') %}
			{% if(contact_message) %}
                <div class="{{ contact_message.class }}">{{ contact_message.text }}</div>
            {% endif %}

<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"></div>
            <div class="post-text">
                <!-- -->
                {% set form = active_form_begin() %}
                {{ form.field(model,'email').textInput({'maxlength': true,'class': 'input margin-17','placeholder': 'Emale Adress...','dir': 'ltr'}) | raw }}
                {{ form.field(model,'captcha').widget('yii\\captcha\\Captcha',{'template': '<div class="captcha-img">{image}</div><div class="captcha-txt">{input}</div>'}) | raw }}
                {{ html.submitButton('لغو عضویت',{'class': 'submit'}) | raw }}
                {% set form = active_form_end() %}
                <!-- -->

            </div>
        </div>
    </div>
</div>