import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { createNote } from '../api';

export default function CreateNotePage() {
  const navigate = useNavigate();
  const [content, setContent] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  async function handleSubmit(e) {
    e.preventDefault();
    setError('');
    setLoading(true);
    try {
      await createNote(content);
      navigate('/');
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="page">
      <div className="form-page">
        <h1>New Blog</h1>
        {error && <p className="error">{error}</p>}
        <form onSubmit={handleSubmit} className="form">
          <label>Blog
            <textarea
              value={content}
              onChange={(e) => setContent(e.target.value)}
              rows={6}
              required
              autoFocus
              placeholder="Write your blog here…"
            />
          </label>
          <div className="form-actions">
            <button type="button" className="btn btn-secondary" onClick={() => navigate('/')}>
              Cancel
            </button>
            <button type="submit" className="btn btn-primary" disabled={loading}>
              {loading ? 'Saving…' : 'Create Blog'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
