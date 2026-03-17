import { Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import VoteButtons from './VoteButtons';
import { deleteNote } from '../api';

export default function NoteCard({ note, onDelete }) {
  const { user } = useAuth();
  const isOwner = user && user.id === note.user_id;

  async function handleDelete() {
    if (!confirm('Delete this blog?')) return;
    try {
      await deleteNote(note.id);
      onDelete(note.id);
    } catch (err) {
      alert('Failed to delete: ' + err.message);
    }
  }

  return (
    <div className="note-card">
      <p className="note-content">{note.body}</p>
      <div className="note-meta">
        <span className="note-author">by {note.user?.name ?? 'Unknown'}</span>
        <span className="note-date">{new Date(note.created_at).toLocaleDateString()}</span>
      </div>
      <div className="note-actions">
        <VoteButtons
          noteId={note.id}
          initialLikes={note.likes_count ?? 0}
          initialDislikes={note.dislikes_count ?? 0}
        />
        <div className="note-owner-actions">
          <Link to={`/notes/${note.id}`} className="btn btn-secondary">View</Link>
          {isOwner && (
            <>
              <Link to={`/notes/${note.id}/edit`} className="btn btn-secondary">Edit</Link>
              <button onClick={handleDelete} className="btn btn-danger">Delete</button>
            </>
          )}
        </div>
      </div>
    </div>
  );
}
