import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

function Register() {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation: passwordConfirmation,
                }),
            });

            const data = await response.json();

            if (response.ok) {
                window.location.href = data.redirect;
            } else {
                setError(data.message || 'Erreur lors de la création du compte.');
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
                <h5 className="mb-0 fw-bold">🏥 Bienvenue sur Clinique Manager</h5>
            </div>

            <div className="flex-grow-1 d-flex align-items-center justify-content-center">
                <div className="bg-white shadow" style={{ width: '100%', maxWidth: '440px', borderRadius: '8px', overflow: 'hidden' }}>
                    <div className="text-center py-4" style={{ backgroundColor: '#2a9d8f' }}>
                        <h4 className="text-white fw-bold mb-0">Créer un compte</h4>
                    </div>

                    <div className="p-4">
                        {error && <div className="alert alert-danger text-center py-2">{error}</div>}

                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <label className="form-label fw-bold">Nom complet</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    value={name}
                                    onChange={(e) => setName(e.target.value)}
                                    required
                                />
                            </div>

                            <div className="mb-3">
                                <label className="form-label fw-bold">Adresse email</label>
                                <input
                                    type="email"
                                    className="form-control"
                                    value={email}
                                    onChange={(e) => setEmail(e.target.value)}
                                    required
                                />
                            </div>

                            <div className="mb-3">
                                <label className="form-label fw-bold">Mot de passe</label>
                                <input
                                    type="password"
                                    className="form-control"
                                    value={password}
                                    onChange={(e) => setPassword(e.target.value)}
                                    required
                                />
                            </div>

                            <div className="mb-4">
                                <label className="form-label fw-bold">Confirmer le mot de passe</label>
                                <input
                                    type="password"
                                    className="form-control"
                                    value={passwordConfirmation}
                                    onChange={(e) => setPasswordConfirmation(e.target.value)}
                                    required
                                />
                            </div>

                            <button
                                type="submit"
                                className="btn w-100 fw-bold text-white"
                                style={{ backgroundColor: '#2a9d8f' }}
                                disabled={loading}
                            >
                                {loading ? 'Création...' : 'Créer mon compte'}
                            </button>
                        </form>

                        <hr />

                        <div className="text-center">
                            <p className="mb-2" style={{ fontSize: '14px' }}>Déjà un compte ?</p>
                            <a href="/login" className="btn w-100 fw-bold text-white" style={{ backgroundColor: '#2a9d8f' }}>
                                Se connecter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Register;