import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            });

            const data = await response.json();

            if (response.ok) {
                window.location.href = data.redirect;
            } else {
                setError(data.message || 'Identifiants incorrects.');
            }
        } catch (err) {
            setError('Erreur de connexion. Veuillez réessayer.');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="min-vh-100 d-flex flex-column" style={{ backgroundColor: 'white' }}>
            <div className="text-white text-center py-3" style={{ backgroundColor: '#2a9d8f' }}>
                <h5 className="mb-0 fw-bold">🏥 Bienvenue sur Clinique Al Afiya</h5>
            </div>

            <div className="flex-grow-1 d-flex align-items-center justify-content-center">
                <div className="bg-white shadow" style={{ width: '100%', maxWidth: '440px', borderRadius: '8px', overflow: 'hidden' }}>
                    <div className="text-center py-4" style={{ backgroundColor: '#2a9d8f' }}>
                        <h4 className="text-white fw-bold mb-0">Connexion</h4>
                    </div>

                    <div className="p-4">
                        {error && <div className="alert alert-danger text-center py-2">{error}</div>}

                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <label className="form-label fw-bold">Adresse email</label>
                                <input
                                    type="email"
                                    className="form-control"
                                    value={email}
                                    onChange={(e) => setEmail(e.target.value)}
                                    placeholder="exemple@email.com"
                                    required
                                />
                            </div>

                            <div className="mb-4">
                                <label className="form-label fw-bold">Mot de passe</label>
                                <input
                                    type="password"
                                    className="form-control"
                                    value={password}
                                    onChange={(e) => setPassword(e.target.value)}
                                    placeholder="••••••••"
                                    required
                                />
                            </div>

                            <button
                                type="submit"
                                className="btn w-100 fw-bold text-white"
                                style={{ backgroundColor: '#2a9d8f' }}
                                disabled={loading}
                            >
                                {loading ? 'Connexion...' : 'Se connecter'}
                            </button>
                        </form>

                        <hr />

                        <div className="text-center">
                            <p className="mb-2" style={{ fontSize: '14px' }}>Pas encore de compte ?</p>
                            <a href="/register" className="btn w-100 fw-bold text-white" style={{ backgroundColor: '#2a9d8f' }}>
                                Créer un compte
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Login;