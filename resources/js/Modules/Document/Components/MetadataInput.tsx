import React, { useState } from "react";
import { Group, ActionIcon, TextInput, Button, Stack } from "@mantine/core";
import { IconPlus, IconTrash } from "@tabler/icons-react";

interface Metadata {
    name: string;
    value: string;
}

interface MetadataInputProps {
    metadata: Metadata[];
    onChange?: (metadata: Metadata[]) => void;
}

const MetadataInput: React.FC<MetadataInputProps> = ({ metadata: initialMetadata, onChange }) => {
    const [metadata, setMetadata] = useState<Metadata[]>(initialMetadata);

    const handleAdd = () => {
        setMetadata([...metadata, { name: "", value: "" }]);
    };

    const handleRemove = (index: number) => {
        const newMetadata = metadata.filter((_, i) => i !== index);
        setMetadata(newMetadata);
        if (onChange) onChange(newMetadata);
    };

    const handleChange = (index: number, field: keyof Metadata, value: string) => {
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