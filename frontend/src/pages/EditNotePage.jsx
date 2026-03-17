import { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { getNote, updateNote } from '../api';
import { useAuth } from '../context/AuthContext';

export default function EditNotePage() {
  const { id } = useParams();
  const { user } = useAuth();
  const navigate = useNavigate();
  const [content, setContent] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    getNote(id)
      .then((note) => {
        if (user && user.id !== note.user_id) {
          navigate('/');
          return;
        }
        setContent(note.body);
      })
      .catch((err) => setError(err.message))
      .finally(() => setLoading(false));
  }, [id, user, navigate]);

  async function handleSubmit(e) {
    e.preventDefault();
    setError('');
    setSaving(true);
    try {
      await updateNote(id, content);
      navigate(`/notes/${id}`);
    } catch (err) {
      setError(err.message);
    } finally {
      setSaving(false);
    }
  }

  if (loading) return <div className="loading">Loading…</div>;

  return (
    <div className="page">
      <div className="form-page">
        <h1>Edit Blog</h1>
        {error && <p className="error">{error}</p>}
        <form onSubmit={handleSubmit} className="form">
          <label>Blog
            <textarea
              value={content}
              onChange={(e) => setContent(e.target.value)}
              rows={6}
              required
              autoFocus
            />
          </label>
          <div className="form-actions">
            <button type="button" className="btn btn-secondary" onClick={() => navigate(`/notes/${id}`)}>
              Cancel
            </button>
            <button type="submit" className="btn btn-primary" disabled={saving}>
              {saving ? 'Saving…' : 'Save Changes'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
