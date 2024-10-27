import React, { useState } from "react";
import { Group, ActionIcon, TextInput, Button, Stack } from "@mantine/core";
import { IconPlus, IconTrash } from "@tabler/icons-react";
import { DocumentMetadata } from "../Types/DocumentMetadata";

interface MetadataInputProps {
    metadata: DocumentMetadata[];
    onChange?: (metadata: DocumentMetadata[]) => void;
    onDelete?: (metadataId: number) => void;
}

const MetadataInput: React.FC<MetadataInputProps> = ({ metadata: initialMetadata, onChange, onDelete }) => {
    const [metadata, setMetadata] = useState<DocumentMetadata[]>(initialMetadata);

    const handleAdd = () => {
        setMetadata([...metadata, { metadata_id: 0, name: "", value: "" }]);
        if (onChange) onChange([...metadata, { metadata_id: 0, name: "", value: "" }]);
    };

    const handleRemove = (index: number) => {
        const removedMeta = metadata[index];
        const newMetadata = metadata.filter((_, i) => i !== index);
        setMetadata(newMetadata);
        if (onChange) onChange(newMetadata);
        if (onDelete && removedMeta.metadata_id !== 0) onDelete(removedMeta.metadata_id);
    };

    const handleChange = (index: number, field: keyof DocumentMetadata, value: string) => {
        const newMetadata = metadata.map((item, i) => (i === index ? { ...item, [field]: value } : item));
        setMetadata(newMetadata);
        if (onChange) onChange(newMetadata);
    };

    return (
        <Stack>
            {metadata.map((meta, index) => (
                <Group key={index} grow align="flex-end">
                    <TextInput
                        label="Name"
                        placeholder="Metadata name"
                        value={meta.name}
                        onChange={(e) => handleChange(index, "name", e.target.value)}
                        required
                    />
                    <TextInput
                        label="Value"
                        placeholder="Metadata value"
                        value={meta.value}
                        onChange={(e) => handleChange(index, "value", e.target.value)}
                        required
                    />
                    <ActionIcon color="red" onClick={() => handleRemove(index)}>
                        <IconTrash size={16} />
                    </ActionIcon>
                </Group>
            ))}
            <Button variant="light" onClick={handleAdd} leftSection={<IconPlus size={14} />}>
                Add Metadata
            </Button>
        </Stack>
    );
};

export default MetadataInput;
