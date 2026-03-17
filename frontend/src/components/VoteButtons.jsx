import { useState } from 'react';
import { likeNote, dislikeNote } from '../api';

export default function VoteButtons({ noteId, initialLikes, initialDislikes }) {
  const [likes, setLikes] = useState(initialLikes);
  const [dislikes, setDislikes] = useState(initialDislikes);
  const [loading, setLoading] = useState(false);

  async function handleVote(type) {
    if (loading) return;
    setLoading(true);
    try {
      const fn = type === 'like' ? likeNote : dislikeNote;
      const data = await fn(noteId);
      setLikes(data.likes);
      setDislikes(data.dislikes);
    } catch (err) {
      console.error('Vote failed:', err.message);
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="vote-buttons">
      <button
        onClick={() => handleVote('like')}
        disabled={loading}
        className="btn btn-vote"
        title="Like"
      >
        👍 {likes}
      </button>
      <button
        onClick={() => handleVote('dislike')}
        disabled={loading}
        className="btn btn-vote"
        title="Dislike"
      >
        👎 {dislikes}
      </button>
    </div>
  );
}
