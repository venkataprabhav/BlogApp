import { useEffect, useState } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { getNote, deleteNote } from '../api';
import { useAuth } from '../context/AuthContext';
import VoteButtons from '../components/VoteButtons';

export default function NoteDetailPage() {
  const { id } = useParams();
  const { user } = useAuth();
  const navigate = useNavigate();
  const [note, setNote] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    getNote(id)
      .then(setNote)
      .catch((err) => setError(err.message))
      .finally(() => setLoading(false));
  }, [id]);

  async function handleDelete() {
    if (!confirm('Delete this blog?')) return;
    try {
      await deleteNote(id);
      navigate('/');
    } catch (err) {
      alert('Failed to delete: ' + err.message);
    }
  }

  if (loading) return <div className="loading">Loading…</div>;
  if (error) return <div className="error">{error}</div>;
  if (!note) return null;

  const isOwner = user && user.id === note.user_id;

  return (
    <div className="page">
      <div className="note-detail">
        <p className="note-content note-content--large">{note.body}</p>
        <div className="note-meta">
          <span>by {note.user?.name ?? 'Unknown'}</span>
          <span>{new Date(note.created_at).toLocaleString()}</span>
        </div>
        <VoteButtons
          noteId={note.id}
          initialLikes={note.likes_count ?? 0}
          initialDislikes={note.dislikes_count ?? 0}
        />
        <div className="note-detail-actions">
          <Link to="/" className="btn btn-secondary">← Back</Link>
          {isOwner && (
            <>
              <Link to={`/notes/${id}/edit`} className="btn btn-secondary">Edit</Link>
              <button onClick={handleDelete} className="btn btn-danger">Delete</button>
            </>
          )}
        </div>
      </div>
    </div>
  );
}
