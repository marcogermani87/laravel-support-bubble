<script>
    function bootstrapSupportForm(element) {
        element.style.display = 'flex';

        const container = element.querySelector('.spatie-support-form__container');
        const formContainer = element.querySelector('.spatie-support-form__form');
        const responseContainer = element.querySelector('.spatie-support-form__response');
        const errorMessage = element.querySelector('.spatie-support-form__error');

        element.querySelector('.spatie-support-form__button button')
            .addEventListener('click', () => {
                responseContainer.style.display = 'none';
                formContainer.style.display = 'flex';
                container.style.display = container.style.display === 'flex' ? 'none' : 'flex';
            });

        element.querySelector('.spatie-support-form__form form')
            .addEventListener('submit', (event) => {
                event.preventDefault();
                const formData = new FormData(event.target)
                const formProps = Object.fromEntries(formData);

                fetch(event.target.action, {
                    headers: {'Content-Type': 'application/json', Accept: 'application/json'},
                    body: JSON.stringify(formProps),
                    method: "post"
                })
                    .then(response => {
                        if (response.status !== 200) throw response;

                        event.target.reset();

                        return response.text();
                    })
                    .then(html => {
                        responseContainer.innerHTML = html;
                        responseContainer.style.display = 'flex';
                        formContainer.style.display = 'none';
                        errorMessage.style.display = 'none';
                    })
                    .catch(async errorResponse => {
                        console.error(errorResponse);

                        const response = await errorResponse.json();

                        errorMessage.style.display = 'block';
                        errorMessage.innerHTML = response.message || 'Something went wrong.';
                    });
            });
    }

    window.addEventListener('load', () => {
        document
            .querySelectorAll('.spatie-support-form')
            .forEach(form => bootstrapSupportForm(form));
    });
</script>