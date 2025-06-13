<x-authlayout>

    <div class="login-back-button">
        <a href="{{ route('login') }}">
            <i class="bi bi-arrow-left-short text-success"></i>
        </a>
    </div>

    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <h4>Welcome, <span class="text-success">{{ $first_name . ' ' . $last_name . ' ' . $extension_name }}</span>
            </h4>
            <p>Enter your 6-digit passkey to continue</p>

            @if ($errors->has('password'))
                <div class="alert alert-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.passkey.verify') }}" id="passkey-form">
                @method('POST')
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">

                <div class="d-flex justify-content-center gap-2 mb-3">
                    @for ($i = 1; $i <= 6; $i++)
                        <input class="form-control text-center passkey-input" type="password" maxlength="1"
                            inputmode="numeric" pattern="[0-9]*" required id="digit{{ $i }}" />
                    @endfor
                </div>

                <!-- Hidden combined password field -->
                <input type="hidden" name="password" id="combined-passkey" />

                <button class="btn btn-success w-100" type="submit">Sign In</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('passkey-form').addEventListener('submit', function(e) {
            let combined = '';
            const inputs = document.querySelectorAll('.passkey-input');
            inputs.forEach(input => combined += input.value);
            document.getElementById('combined-passkey').value = combined;
        });

        // Optional: Auto focus to next input
        const inputs = document.querySelectorAll('.passkey-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });
    </script>
</x-authlayout>
