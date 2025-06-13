<x-authlayout>

    <div class="login-back-button">
        <a href="{{ route('login') }}">
            <i class="bi bi-arrow-left-short text-success"></i>
        </a>
    </div>


    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <h4>Hello, <span class="text-success">{{ $first_name . ' ' . $last_name . ' ' . $extension_name }}</span>
            </h4>
            <p>Create your 6-digit passkey</p>

            <form method="POST" action="{{ route('login.passkey.register') }}" id="passkey-register-form">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">

                <!-- Label and Passkey Input -->
                <div class="mb-2 text-center">
                    <label class="form-label">Enter 6-digit passkey</label>
                </div>

                <div class="d-flex justify-content-center gap-2 mb-3">
                    @for ($i = 1; $i <= 6; $i++)
                        <input class="form-control text-center passkey-input" type="password" maxlength="1"
                            inputmode="numeric" pattern="[0-9]*" required id="passkey{{ $i }}" />
                    @endfor
                </div>

                <x-form-error name='password' />

                <!-- Label and Confirm Passkey Input -->
                <div class="mb-2 text-center">
                    <label class="form-label">Confirm passkey</label>
                </div>
                <div class="d-flex justify-content-center gap-2 mb-3">
                    @for ($i = 1; $i <= 6; $i++)
                        <input class="form-control text-center confirm-passkey-input" type="password" maxlength="1"
                            inputmode="numeric" pattern="[0-9]*" required id="confirm{{ $i }}" />
                    @endfor
                </div>

                <x-form-error name='password_confirmation' />

                <!-- Hidden Inputs -->
                <input type="hidden" name="password" id="combined-passkey">
                <input type="hidden" name="password_confirmation" id="combined-confirm-passkey">

                <button class="btn btn-success w-100 py-2" type="submit">Save Passkey</button>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('passkey-register-form');

        form.addEventListener('submit', function(e) {
            let passkey = '';
            let confirmPasskey = '';

            document.querySelectorAll('.passkey-input').forEach(input => passkey += input.value);
            document.querySelectorAll('.confirm-passkey-input').forEach(input => confirmPasskey += input.value);

            document.getElementById('combined-passkey').value = passkey;
            document.getElementById('combined-confirm-passkey').value = confirmPasskey;
        });

        function handleAutoFocus(selector) {
            const inputs = document.querySelectorAll(selector);
            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && input.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
        }

        handleAutoFocus('.passkey-input');
        handleAutoFocus('.confirm-passkey-input');
    </script>
</x-authlayout>
