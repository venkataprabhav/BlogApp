import { useEffect, useState } from 'react';
import { getNotes } from '../api';
import NoteCard from '../components/NoteCard';

export default function NotesIndexPage() {
  const [notes, setNotes] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    getNotes()
      .then((data) => setNotes(data.data ?? data))
      .catch((err) => setError(err.message))
      .finally(() => setLoading(false));
  }, []);

  function handleDelete(id) {
    setNotes((prev) => prev.filter((n) => n.id !== id));
  }

  if (loading) return <div className="loading">Loading blogs…</div>;
  if (error) return <div className="error">{error}</div>;

  return (
    <div className="page">
      <h1>All Blogs</h1>
      {notes.length === 0 ? (
        <p>No blogs yet. Be the first to create one!</p>
      ) : (
        <div className="notes-grid">
          {notes.map((note) => (
            <NoteCard key={note.id} note={note} onDelete={handleDelete} />
          ))}
        </div>
      )}
    </div>
  );
}
